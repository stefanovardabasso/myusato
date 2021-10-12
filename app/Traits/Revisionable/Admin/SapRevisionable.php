<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait SapRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['date'];

    public static $revisionableRoute = 'admin.saps.show';
}

