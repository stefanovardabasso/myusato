<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait Questions_sapRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['code_q'];

    public static $revisionableRoute = 'admin.questions_saps.show';
}

