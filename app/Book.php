<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name','description','image','text'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public static function form(){
        return [
            'name' => '',
            'description' => '',
            'image' => '',
            'text' => ''
        ];
    }
}
