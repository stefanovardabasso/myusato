<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait QuotationRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['id_user'];

    public static $revisionableRoute = 'admin.quotations.show';
}

