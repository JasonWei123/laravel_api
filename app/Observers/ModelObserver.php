<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use App\Events\DefaultLoggable;

class ModelObserver
{
    /**
     * 模型新建后
     */
    public function created(Model $model)
    {
        $attributes = $model->getAttributes();
        $attributes = Arr::except($attributes, ['created_at', 'updated_at']);

        $modelName = get_class($model);
        $modelId = $model->getKey();
        $title = "新建【{$modelName}】模型";
        $content = "模型数据：" . json_encode($attributes, 320);

        event(new DefaultLoggable($title, $content, null, $modelName, $modelId));
    }

    /**
     * 只有确定更新后才记录日志
     */
    public function updated(Model $model)
    {
        $dirty = $model->getDirty();
        $original = $model->getOriginal();

        // 有时候可能只要监控某些字段
        if (method_exists($model, 'limitObservedFields')) {
            $fields = $model->limitObservedFields();
            $dirty = Arr::only($dirty, $fields);
            $original = Arr::only($original, array_keys($dirty));
        } else {
            $dirty = Arr::except($dirty, ['updated_at']);
            $original = Arr::only($original, array_keys($dirty));
        }

        if (count($dirty)) {
            $modelName = get_class($model);
            $modelId = $model->getKey();
            $title = "修改【{$modelName}】模型";
            $content = "数据修改前：" . json_encode($original, 320) . "；数据修改后：" . json_encode($dirty, 320);
            event(new DefaultLoggable($title, $content, null, $modelName, $modelId));
        }
    }

    /**
     * 模型删除后
     */
    public function deleted(Model $model)
    {
        $attributes = $model->getAttributes();

        $modelName = get_class($model);
        $modelId = $model->getKey();
        $title = "删除【{$modelName}】模型";
        $content = "模型数据：" . json_encode($attributes, 320);

        event(new DefaultLoggable($title, $content, null, $modelName, $modelId));
    }
}