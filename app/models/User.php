<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait, SoftDeletingTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = ['*'];
    protected $hidden = ['password', 'remember_token', 'deleted_at'];
    protected $dates = ['deleted_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * User following relationship
     */
    public function follow()
    {

      return $this->belongsToMany('User', 'user_follows', 'user_id', 'follow_id');
    }

     /**
     * User followers relationship
     */
    public function followers()
    {
      return $this->belongsToMany('User', 'user_follows', 'follow_id', 'user_id');
    }

    public function setPassword($password)
    {
        $this->password = Hash::make($password);
    }

    public function isAdmin()
    {
        return $this->role == 1;
    }
}
