<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model {
  protected $fillable = ['description','image', 'title', 'subtitle', 'user_id', 'category_id'];    

  public function Category() {
    return $this->belongsTo('App\Category');
  }

  public function User() {
    return $this->belongsTo('App\User');
  }

}
