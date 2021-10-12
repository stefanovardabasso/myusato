<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    /**
     *
     */
    public static function boot()
    {
        @parent::boot();

        self::created(function($media) {
            self::createRevision($media, 'created');
        });

        self::deleted(function($media) {
            self::createRevision($media, 'deleted');
        });
    }

    /**
     * @param $media
     * @param $type
     * @return bool
     */
    private static function createRevision($media, $type)
    {
        $model = $media->model;

        if (!method_exists($model, 'hasRevisionableMediaCollection')
            || !$model->hasRevisionableMediaCollection($media->collection_name)
        ) {
            return false;
        }

        $data = [
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'type' => $type,
            'ip' => request()->getClientIp(),
            'creator_id' => Auth::check() ? Auth::id() : null,
            'locale' => Auth::check() ? Auth::user()->locale : null,
        ];

        if ($type == 'created') {
            $data['old'] = null;
            $data['new'] = [$media->collection_name . '-form-label' => [$media->file_name]];
        } else if ($type == 'deleted') {
            $data['old'] = [$media->collection_name . '-form-label' => [$media->file_name]];
            $data['new'] = null;
        }

        Revision::create($data);
    }
}
