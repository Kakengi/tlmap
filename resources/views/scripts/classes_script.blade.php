<script>
    $(function() {
        var selected_school_type_id = $("#school-type").val();
        var url = "{{ route('ajax.get_school_classes') }}"

        if (selected_school_type_id) {
            // var selected_school_class_id = "{{ json_encode(request()->get('school_class_id')) }}";
            url = url + "?" + window.location.href.split('?')[1];
            var data = {
                school_type_id: selected_school_type_id
            , }
            ajaxRequest(url, data, 'JSON', 'GET', getResponse)
        }

        $('#school-type').on('change', function() {
            var school_type_id = $(this).val()

            var data = {
                school_type_id: school_type_id
            }
            ajaxRequest(url, data, 'JSON', 'GET', getResponse)
        })

        function getResponse(res) {
            $("#school-class").html(res.data)
        }
    });

</script>
