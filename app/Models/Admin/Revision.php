<?php

namespace App\Models\Admin;

use App\Traits\Revisionable\Revisionable;
use App\Traits\Translations\Admin\RevisionTranslation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\DataTables\Admin\RevisionDataTable;
use function route;

class Revision extends Model
{
    use RevisionDataTable;
    use RevisionTranslation;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'old' => 'array',
        'new' => 'array',
    ];

    private static $modelsConfig;

    public function revisionable()
    {
        return $this->morphTo();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }

    /**
     * @param $path
     * @return array
     */
    private static function getModels($path)
    {
        $classes = \File::allFiles($path);
        $classNames = [];
        foreach ($classes as $class) {
            $classNames[] = str_replace(
                [app_path(), '/', '.php'],
                ['App', '\\', ''],
                $class->getRealPath()
            );
        }
        return $classNames;
    }

    /**
     * @return array
     */
    private static function getModelsConfig()
    {
        if (empty(self::$modelsConfig)) {
            foreach (self::getModels(app_path('Models')) as $class) {
                if (!array_key_exists(Revisionable::class, class_uses_recursive($class))) {
                    continue;
                }
                $config = [
                    'title' => null,
                    'route' => null
                ];
                if (method_exists($class, 'getTitleTrans')) {
                    $config['title'] = $class::getTitleTrans();
                }
                if (property_exists($class, 'revisionableRoute')) {
                    $config['route'] = $class::$revisionableRoute;
                }
                self::$modelsConfig[$class] = $config;
            }
        }

        return self::$modelsConfig;
    }

    /**
     * @param $modelType
     * @return mixed|string
     */
    public static function getModelSection($modelType)
    {
        $config = self::getModelsConfig();

        if (array_key_exists($modelType, $config) && !empty($config[$modelType]['title'])) {
            return $config[$modelType]['title'];
        }
        return '';
    }

    /**
     * @param $modelType
     * @param $modelId
     * @return string
     */
    public static function getModelRoute($modelType, $modelId)
    {
        $config = self::getModelsConfig();

        $route = '';

        if (array_key_exists($modelType, $config) && !empty($config[$modelType]['route']) && $modelType::find($modelId)) {
            $route = route($config[$modelType]['route'], [$modelId]);
        }

        return $route;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getModelsSelectFilter()
    {
        $config = self::getModelsConfig();
        $filter = [];

        foreach ($config as $modelType => $modelCnf) {
            $filter[] = (object) [
                'value' => $modelType,
                'label' => $modelCnf['title']
            ];
        }

        return collect($filter);
    }
}
