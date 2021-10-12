<?php

namespace App\Models\Admin;
use App\Traits\Translations\Admin\OptionTranslation;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Revisionable\Admin\OptionRevisionable;
use App\Traits\DataTables\Admin\OptionDataTable;

class Option extends Model
{
    use OptionDataTable;
    use OptionRevisionable;
    use OptionTranslation;
    const CREATED_AT = 'created_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'options';

    public function offer() {
        return $this->belongsTo(Offert::class,'offer_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
