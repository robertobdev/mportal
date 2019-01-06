<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
  protected $fillable = ['description', 'status'];
  
  public function stories() {
    return $this->hasMany(Story::class);
  }
}
