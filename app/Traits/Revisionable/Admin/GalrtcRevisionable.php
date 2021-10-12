<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait GalrtcRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['product_id'];

    public static $revisionableRoute = 'admin.galrtcs.show';
}

