<?php

namespace App\Enums;

use App\Traits\ExtractConstant;

class RoleRouteEnum
{
    use ExtractConstant;

    const ROUTE = [
        RoleEnum::ADMIN_FORM => [
            'admin.form',
            'admin.form.tambah',
            'admin.form.edit',
            'admin.form.tambah-action',
            'admin.form.edit-action',
        ],
        RoleEnum::FREELANCE => []
    ];
}
