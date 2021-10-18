<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait BlocksoftextRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['alias'];

    public static $revisionableRoute = 'admin.blocksoftexts.show';
}

