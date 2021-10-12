<?php

namespace App\Models\Admin;

use App\Notifications\DataTablesExportDone;
use App\Traits\Translations\Admin\ReportTranslation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use App\Traits\DataTables\Admin\ReportDataTable;

class Report extends Model implements HasMedia
{
    use HasMediaTrait;
    use ReportDataTable;
    use ReportTranslation;

    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var array
     */
    protected $dates = ['date_start', 'date_end'];
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    /**
     * @return Report
     */
    protected function start($modelTarget)
    {
        return self::create([
            'date_start' => Carbon::now(),
            'creator_id' => Auth::id(),
            'state' => 'in_progress',
            'model_target' => $modelTarget,
        ]);
    }

    /**
     * @param $tmpFilePath
     */
    public function finish($tmpFilePath)
    {
        $file = storage_path('app/' . $tmpFilePath);

        $this->addMedia($file)
            ->toMediaCollection('exported');

        $this->date_end = Carbon::now();
        $this->state = 'completed';
        $this->save();

        $this->creator->notify(new DataTablesExportDone($this->fresh()));
    }

    /**
     * @param $message
     */
    public function fail($message)
    {
        $this->message = $message;
        $this->date_end = Carbon::now();
        $this->state = 'failed';

        $this->save();

        $this->creator->notify(new DataTablesExportDone($this->fresh()));
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('exported')
            ->singleFile();
    }
}
