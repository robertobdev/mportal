<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Category;

class CategoryController extends Controller {
  public function index() {
    $stories = Category::get();

    return $stories->toJson();
  }

  public function store(Request $request) {
    
    // $validatedDate = $request->validate([
    //   'description' => 'required', 
    //   'title' => 'required', 
    //   'subtitle' => 'required',
    //   'user_id' => 'required', 
    //   'category_id' => 'required'
    // ]);

    // $store = Story::create([
    //   'description' => $validatedDate['description'],
    //   'title' => $validatedDate['title'],
    //   'subtitle' => $validatedDate['subtitle'],
    //   'user_id' => $validatedDate['user_id'],
    //   'category_id' => $validatedDate['category_id'],
    //   'image' => $path
    // ]);

    // return response()->json('Story created!');
  }
  public function show($id) {
    $story = Story::with(['categories'])->find($id);
    return $story->toJson();
  }

}
