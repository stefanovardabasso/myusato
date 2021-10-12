<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait Products_lineRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['id_product'];

    public static $revisionableRoute = 'admin.products_lines.show';
}

