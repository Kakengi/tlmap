<?php 

foreach ($user->roles as $key => $role) {
    ?>
    <span class="badge badge-secondary">{{ $role->name }}</span>
    <?php
}