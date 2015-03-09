<?php

class Activity extends BaseModel
{
    protected $table = 'activities';
    protected $fillable = ['*'];

    // public function lesson()
    // {
    //     return $this->hasOne('Lesson', "lesson_id", "id");
    // }
}
