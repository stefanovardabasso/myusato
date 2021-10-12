<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\VendorplaceTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\VendorplaceRevisionable;
use App\Traits\DataTables\Admin\VendorplaceDataTable;

class Vendorplace extends Model
{
    use VendorplaceDataTable;
    use VendorplaceRevisionable;
    use VendorplaceTranslation;

    protected $guarded = [];
}
