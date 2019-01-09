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
    return $request;
    $validatedDate = $request->validate([
      'description' => 'required', 
      'title' => 'required', 
      'subtitle' => 'required',
      'category_id' => 'required'
    ]);

    $path = "uploads/" . $this->storageImage($request->image);

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
  public function update(Request $request, $id) {
    if (strpos($request->image, 'data:image') !== false) {
      $this->storageImage($request->image, str_replace('/uploads', '', $request->imagePath));
    }

    return $request->all();

    Story::update($request->all()):
    // if ($request->user()->id !== $store->user_id) {
    //   return response()->json(['error' => 'You can only edit your own books.'], 403);
    // }

    // $store->update($request->only(['title', 'description']));
    return response()->json('Story updated!');
    // return new BookResource($store);
  }

  private function storageImage($base64, $name = null) {
    $image = str_replace('data:image/png;base64,', '', $base64);
    $image = str_replace(' ', '+', $image);

    $imageName = $name ? $name : str_random(20).'.png';
    \File::put(storage_path(). '/app/public/uploads/' . $imageName, base64_decode($image));
    return $imageName;
  }

  public function show($id) {
    $story = Story::with(['category'])->find($id);
    return $story->toJson();
  }
}
