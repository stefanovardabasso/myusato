<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait PlaceRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['name'];

    public static $revisionableRoute = 'admin.places.show';
}
