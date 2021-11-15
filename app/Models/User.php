<?php

namespace App\Models;

use App\Models\Traits\CustomTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use CustomTime;

    protected $guarded = [];

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
}
