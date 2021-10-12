<?php

namespace App\Models\Admin;

use App\Traits\Revisionable\Admin\FaqQuestionRevisionable;
use App\Traits\Translations\Admin\FaqQuestionTranslation;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use App\Traits\DataTables\Admin\FaqQuestionDataTable;

class FaqQuestion extends Model implements HasMedia
{
    use HasMediaTrait;
    use FaqQuestionRevisionable;
    use FaqQuestionDataTable;
    use FaqQuestionTranslation;

    protected $guarded = ['attachments'];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('attachments');
    }
}
