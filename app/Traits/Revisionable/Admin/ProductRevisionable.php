<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait ProductRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['family'];

    public static $revisionableRoute = 'admin.products.show';
}

