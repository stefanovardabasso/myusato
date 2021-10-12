<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait RoleRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['role_name'];

    public static $revisionableRoute = 'admin.roles.show';
}

