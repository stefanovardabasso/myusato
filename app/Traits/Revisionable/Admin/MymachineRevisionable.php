<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait MymachineRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['id_offert'];

    public static $revisionableRoute = 'admin.mymachines.show';
}

