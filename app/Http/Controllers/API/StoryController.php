<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Story;
class StoryController extends Controller {

  public function index() {
    $stories = Story::with(['category', 'user'])->get();

    return $stories->toJson();
  }

  public function store(Request $request) {
    $file = $request->file('file');
    $ext = $file->extension();
    $name = str_random(20).'.'.$ext ;
    list($width, $height) = getimagesize($file);
    $path = Storage::disk('public')->putFileAs(
      'uploads', $file, $name
    );

    $validatedDate = $request->validate([
      'description' => 'required', 
      'title' => 'required', 
      'subtitle' => 'required',
      'user_id' => 'required', 
      'category_id' => 'required',
      'image' => 'required'
    ]);

    $store = Story::create([
      'description' => $validatedDate['description'],
      'title' => $validatedDate['title'],
      'subtitle' => $validatedDate['subtitle'],
      'user_id' => $validatedDate['user_id'],
      'category_id' => $validatedDate['category_id']
    ]);

    return response()->json('Story created!');
  }
  public function show($id) {
    $story = Story::with(['categories'])->find($id);
    return $story->toJson();
  }
}
