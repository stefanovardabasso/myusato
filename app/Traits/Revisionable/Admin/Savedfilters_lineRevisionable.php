<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait Savedfilters_lineRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['saved_id'];

    public static $revisionableRoute = 'admin.savedfilters_lines.show';
}

