<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait OffertRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['createdby'];

    public static $revisionableRoute = 'admin.offerts.show';
}

