<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait Fam_selectRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['id_button'];

    public static $revisionableRoute = 'admin.fam_selects.show';
}

