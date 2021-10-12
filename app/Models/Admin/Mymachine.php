<?php

namespace App\Models\Admin;

use App\Models\Admin\Offert;
use App\Traits\Translations\Admin\MymachineTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\MymachineRevisionable;
use App\Traits\DataTables\Admin\MymachineDataTable;
use Illuminate\Support\Facades\Auth;

class Mymachine extends Model
{
    use MymachineDataTable;
    use MymachineRevisionable;
    use MymachineTranslation;

    protected $guarded = [];

    public function getPriceByRole($offerId)
    {
        $price = Offert::query()->where('id','=', $offerId)->first();
        if(Auth::check()){
            $role = auth()->user()->getrole();

            if($role[0]->id == '2' || $role[0]->id == '3'){
                return $price->price_co;
            }else{
                return $price->price_uf;
            }
        }else{
            return $price->price_uf;
        }


    }
}
