<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait VtuRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['email'];

    public static $revisionableRoute = 'admin.vtus.show';
}

