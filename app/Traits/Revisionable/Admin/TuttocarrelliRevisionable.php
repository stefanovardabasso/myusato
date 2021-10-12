<?php

namespace App\Traits\Revisionable\Admin;

use App\Traits\Revisionable\Revisionable;

trait TuttocarrelliRevisionable
{
    use Revisionable;

    protected $revisionableAttributes = ['offert_id'];

    public static $revisionableRoute = 'admin.tuttocarrellis.show';
}

