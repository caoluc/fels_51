<?php

class Word extends BaseModel
{
    protected $table = 'words';
    protected $fillable = ['*'];

    public function answer()
    {
        return $this->hasOne('Answer', "word_id", "id");
    }
}
