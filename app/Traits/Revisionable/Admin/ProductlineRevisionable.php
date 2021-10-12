<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait ProductlineRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['id_product'];

    public static $revisionableRoute = 'admin.productlines.show';
}

