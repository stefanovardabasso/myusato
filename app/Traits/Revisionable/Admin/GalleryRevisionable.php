<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait GalleryRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['offert_id'];

    public static $revisionableRoute = 'admin.gallerys.show';
}

