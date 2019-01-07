<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Story;
use Illuminate\Support\Facades\Storage;
class StoryController extends Controller {

  public function index() {
    $stories = Story::with(['category', 'user'])->get();

    return $stories->toJson();
  }

  public function store(Request $request) {
    
    $validatedDate = $request->validate([
      'description' => 'required', 
      'title' => 'required', 
      'subtitle' => 'required',
      'category_id' => 'required'
    ]);

    $file = $request->file('image');
    $ext = $file->extension();
    $name = str_random(20).'.'.$ext ;
    $path = Storage::disk('public')->putFileAs(
      'uploads', $file, $name
    );

    $store = Story::create([
      'description' => $validatedDate['description'],
      'title' => $validatedDate['title'],
      'subtitle' => $validatedDate['subtitle'],
      'user_id' => $request->user()->id,
      'category_id' => $validatedDate['category_id'],
      'image' => $path
    ]);

    return response()->json('Story created!');
  }
  public function show($id) {
    $story = Story::with(['categories'])->find($id);
    return $story->toJson();
  }
}
