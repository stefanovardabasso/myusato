<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait SuprliftRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['offert_id'];

    public static $revisionableRoute = 'admin.suprlifts.show';
}

