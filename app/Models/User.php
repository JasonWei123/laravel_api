<?php

namespace App\Models;

use App\Models\Traits\CustomTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Searchable;
    use CustomTime;

    protected $guarded = [];
    protected $hidden = ['password'];

    /**
     * 获取索引名称
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'users_index';
    }
    /**
     * 获取模型的可搜索数据
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // 自定义数组...

        return $array;
    }

    /**
     * 获取模型主键
     *
     * @return mixed
     */
    public function getScoutKey()
    {
        return $this->id;
    }


    public static function findByAccount(string $account)
    {
        return static::query()
            ->where('account', $account)
            ->first();
    }

    public function setLastIpAttribute($value)
    {
        $this->attributes['last_ip'] = ip2long($value);
    }

    public function getLastIpAttribute($value)
    {
        return long2ip($value);
    }

    public function getCreatedAtAttribute()
    {
        $postDate = new Carbon($this->attributes['created_at_gmt'], 'UTC');
        return $postDate->tz(config('app.timezone'))->toDateTimeString();
    }

    public function getUpdatedAtAttribute()
    {
        $postModified = new Carbon($this->attributes['updated_at_gmt'], 'UTC');
        return $postModified->tz(config('app.timezone'))->toDateTimeString();
    }

    public function getDescAttribute($value)
    {
        return __($value);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
