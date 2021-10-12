<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait MacuRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['offert_id'];

    public static $revisionableRoute = 'admin.macus.show';
}

