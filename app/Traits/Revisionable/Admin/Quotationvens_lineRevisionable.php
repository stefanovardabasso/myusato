<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait Quotationvens_lineRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['id_quotationven'];

    public static $revisionableRoute = 'admin.quotationvens_lines.show';
}

