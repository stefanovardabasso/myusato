<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait Buttons_filterRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['button_it'];

    public static $revisionableRoute = 'admin.buttons_filters.show';
}

