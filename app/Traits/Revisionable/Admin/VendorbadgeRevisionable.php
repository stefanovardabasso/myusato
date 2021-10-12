<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait VendorbadgeRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['user_id'];

    public static $revisionableRoute = 'admin.vendorbadges.show';
}

