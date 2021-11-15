<?php
namespace App\Models\Traits;
use Illuminate\Support\Carbon;
trait CustomTime
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function setCreatedAt($value)
    {
        $gmt_field = static::CREATED_AT . '_gmt';
        $this->{$gmt_field} = $value;
        return parent::setCreatedAt($value);
    }
    /**
     * @param mixed $value
     * @return mixed
     */
    public function setUpdatedAt($value)
    {
        $gmt_field = static::UPDATED_AT . '_gmt';
        $this->{$gmt_field} = $value;
        return parent::setUpdatedAt($value);
    }
    /**
     * 直接返回原始数据。
     *
     * @remark 如果套一层Carbon，默认使用的是本地时区
     * 就算明确改成UTC，在toArray的时候会出现Carbon对象转换成JSON的问题，需要定义一个toArray返回正确的数据
     * 这里直接简单处理，返回原始数据，可考虑用toArray优化。
     *
     * https://github.com/laravel/framework/issues/16083
     */
    public function getCreatedAtGmtAttribute()
    {
        return $this->attributes['created_at_gmt'];
    }
    /**
     * *_gmt字段存储到数据库固定使用UTC时间
     */
    public function setCreatedAtGmtAttribute($value)
    {
        $this->attributes['created_at_gmt'] = (new Carbon($value))->timezone('UTC')->toDateTimeString();
    }
    public function getUpdatedAtGmtAttribute()
    {
        return $this->attributes['updated_at_gmt'];
    }
    /**
     * *_gmt字段存储到数据库固定使用UTC时间
     */
    public function setUpdatedAtGmtAttribute($value)
    {
        $this->attributes['updated_at_gmt'] = (new Carbon($value))->timezone('UTC')->toDateTimeString();
    }
}
