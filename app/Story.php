<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model {
  protected $fillable = ['description', 'title', 'subtitle', 'user_id', 'category_id'];    
}
