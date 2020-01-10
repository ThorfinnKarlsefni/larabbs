<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Topic;
use App\Models\Reply;
use Auth;

class User extends Authenticatable
{
    use Traits\ActiveUserHelper;

    use Notifiable {
        notify as protected laravelNotify;
    }

    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password','introduction','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if($this->id == Auth::id()){
            return;
        }

        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    public function setPasswordAttribute($value)
    {
        if(strlen($value) != 60)
        {
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    public function setAvatarAttribute($path)
    {
        if(! starts_with($path,'http')){
            $path = config('app.url')."/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }
}