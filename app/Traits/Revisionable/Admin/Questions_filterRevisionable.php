<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait Questions_filterRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['cod_fam'];

    public static $revisionableRoute = 'admin.questions_filters.show';
}

