<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Category extends BaseModel
{
    use SoftDeletingTrait;

    protected $table = 'categories';
    public $incrementing = true;
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'deleted_at','updated_at','created_at'];
    protected $dates = ['deleted_at'];
    protected $hidden = ['deleted_at'];
    protected $fillable = ['*'];
}
