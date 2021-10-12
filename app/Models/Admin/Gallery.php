<?php

namespace App\Models\Admin;

use App\Traits\Translations\Admin\GalleryTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\GalleryRevisionable;
use App\Traits\DataTables\Admin\GalleryDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Offert;

class Gallery extends Model
{
    use GalleryDataTable;
    use GalleryRevisionable;
    use GalleryTranslation;

    protected $guarded = [];

    public function getGallery($offerId) {


       $of = Offert::query()->where('id',$offerId)->first();

       if($of->target_user == '1'){
           $type = 'UF';
       }else{
           $type = 'CO';
       }

        $gallery = DB::table('galleries')
            ->select('name')
            ->where('offert_id','=',$offerId)
            ->where('type','=',$type)
            ->orderBy('position','ASC')
            ->get();

        return $gallery;
    }
}
