<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Publication;
use App\Models\SchoolRequirement;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Boolean;

use function PHPUnit\Framework\fileExists;

class HelperService
{

    public function getTotalNumStudentBook($year, $school_name, $school_type_id, $school_class_id, $subject_id)
    {
        $items = SchoolRequirement::selectRaw("
                SUM(num_students) AS total_num_students,
                SUM(required_books) AS total_required_books
        ")
            ->search($school_name, $school_type_id, $school_class_id, $subject_id)
            ->filterByYear($year)
            ->groupBy('year_of_study')
            ->first();
        return $items;
    }

    public function uploadFile($request, $existing_filename, $action = false)
    {
        $file = $request->file('filename');
        if ($file) {
            $destination_path = public_path('/storage/books');
            if ($action == 'update' && $existing_filename && fileExists($destination_path . '/' . $existing_filename)) {
                unlink($destination_path . '/' . $existing_filename);
            }
            $file_name = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            if (!file_exists($destination_path . '/' . $file_name)) {
                $file->move($destination_path, $file_name);
                return $file_name;
            }
        }
        return '';
    }

    public function receivedBooks($request)
    {

        $query = Contract::groupBy("publication_id")->selectRaw("
        publications.id AS publication_id,
        publications.is_large_print AS is_large_print,
        SUM((receipts.number_of_boxes * receipts.quantity_per_box) + IFNULL(receipts.loose , 0)) AS quantity,
        publications.publication_title AS title
        ")
            ->join("publication_contract", "publication_contract.contract_id", "=", "contracts.id")
            ->join("publications", "publications.id", "=", "publication_contract.publication_id")
            ->join("books", "books.id", "=", "publications.book_id")
            ->join("receipts", "receipts.publication_contract_id", "=", "publication_contract.id")
            ->where("contracts.id", $request->contract_id)
            ->where("contracts.year_of_study", $request->year_of_study)
            ->where("receipts.status", "received");
        if ($request->publication_id) {
            $query->where('publications.id', $request->publication_id);
        }
        if (isset($request->is_for_sale) && !filter_var($request->is_for_sale, FILTER_VALIDATE_BOOL)) {
            $query->where('publication_contract.is_for_sale', false);
        }

        return $query->orderBy('publication_id');
    }

    public function getBulkLGAsData($request)
    {
        // $requirements = SchoolRequirement::groupBy(["district_id",  "school_class_id", "subject_id"])
        //     ->selectRaw("
        //                 district_id ,
        //                 school_class_id,
        //                 subject_id,
        //                 SUM(required_books) AS quantity
        //     ");
        $book_infos = [];
        $requirement_datas = [];
        $request['is_for_sale'] = false;
        $receivedPublications = $this->receivedBooks($request)->get();

        foreach ($receivedPublications as $item) {
            $publication = Publication::find($item->publication_id);
            $receipt = $publication->receipts()->where('contract_id', $request->contract_id)->first();
            $book = $publication->book()->whereIn('book_category_id', [1])->first();
            if ($book) {
                $book_infos[] = [
                    'school_class_id' => $book->school_class_id,
                    'subject_id' => $book->subject_id,
                    'quantity' => (int)$item->quantity,
                    'title' => $item->title,
                    'publication_id' => $item->publication_id,
                    // 'receipt' => $receipt,
                    'contract_id' => $request->contract_id,
                ];
            }
        }

        foreach ($book_infos as $i => $info) {
            $datas = SchoolRequirement::whereRaw(
                'school_class_id=? AND subject_id = ?',
                [
                    $info['school_class_id'],
                    $info['subject_id'],
                ]
            );

            if ($request->district_id) {
                $datas = $datas->whereRaw("district_id = ?", [$request->district_id]);
            }

            if ($request->region_id) {
                $datas = $datas->whereRaw("region_id = ?", [$request->region_id]);
            }

            $datas = $datas->get();

            foreach ($datas as $j => $data) {
                $quantity_per_box = $receipt->quantity_per_box;
                $required_quantity = $data->required_books;
                $requirement_datas[] = [
                    'district_id' => $data->district_id,
                    // 'district_name' => $data->district_name,
                    // 'subject' => $data->subject->name,
                    // 'class' => $data->schoolClass->name,
                    'publication_id' => $info['publication_id'],
                    // 'book_title' => $info['title'],
                    'quantity_required' => $required_quantity,
                    // 'received_quantity' => $info['quantity'],
                    // 'receipts' => $info['receipts']
                    'contract_id' => $info['contract_id'],
                    'quantity_per_box' => $quantity_per_box,
                    'year_of_study' => $request->year_of_study,
                    'number_of_boxes' => floor($required_quantity / $quantity_per_box),
                    'loose' => $required_quantity % $quantity_per_box,
                    'created_by' => auth()->id(),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ];
            }
        }
        return $requirement_datas;
    }
}
