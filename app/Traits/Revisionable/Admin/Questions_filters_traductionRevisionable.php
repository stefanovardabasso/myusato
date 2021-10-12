<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait Questions_filters_traductionRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['cod_fam'];

    public static $revisionableRoute = 'admin.questions_filters_traductions.show';
}

