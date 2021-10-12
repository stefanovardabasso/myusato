<?php

namespace App\Imports;


use App\Models\Admin\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

         new Product([
            'id'=>$row[0]
        ]);

         return true;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $col){
            new Product([
                'id'=>$col[0]
            ]);
        }

    }
}
