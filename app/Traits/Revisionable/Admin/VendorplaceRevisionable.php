<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait VendorplaceRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['user_id'];

    public static $revisionableRoute = 'admin.vendorplaces.show';
}

