<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait ContactformRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['from_email'];

    public static $revisionableRoute = 'admin.contactforms.show';
}

