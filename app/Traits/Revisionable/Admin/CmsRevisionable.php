<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait CmsRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['name'];

    public static $revisionableRoute = 'admin.cmss.show';
}

