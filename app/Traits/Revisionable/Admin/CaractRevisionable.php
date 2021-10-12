<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait CaractRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['cc'];

    public static $revisionableRoute = 'admin.caracts.show';
}

