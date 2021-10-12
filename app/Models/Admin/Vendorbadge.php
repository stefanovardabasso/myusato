<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\VendorbadgeTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\VendorbadgeRevisionable;
use App\Traits\DataTables\Admin\VendorbadgeDataTable;

class Vendorbadge extends Model
{
    use VendorbadgeDataTable;
    use VendorbadgeRevisionable;
    use VendorbadgeTranslation;

    protected $guarded = [];
}
