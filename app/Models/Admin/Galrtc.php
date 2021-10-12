<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\GalrtcTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\GalrtcRevisionable;
use App\Traits\DataTables\Admin\GalrtcDataTable;

class Galrtc extends Model
{
    use GalrtcDataTable;
    use GalrtcRevisionable;
    use GalrtcTranslation;

    protected $guarded = [];
}
