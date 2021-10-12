<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait Quotation_lineRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['id_quotation'];

    public static $revisionableRoute = 'admin.quotation_lines.show';
}

