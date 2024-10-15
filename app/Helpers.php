<?php

use Spatie\Permission\Models\Role;

if (!function_exists('roleDropdown')) {
    function roleDropdown()    {
        $roles = Role::all()->pluck('name', 'id');
        return $roles;
    }
}
