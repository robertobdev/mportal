<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Story;
use Illuminate\Support\Facades\Storage;
class StoryController extends Controller {

  public function index() {
    /* TODO: only get stories by user id
    */
    $stories = Story::with(['category', 'user'])->get();

    return $stories->toJson();
  }
  public function getAll() {
    $mainStory = Story::with(['category', 'user:id,name'])->orderBy('count', 'desc')->first();
    $highlights = Story::with(['category', 'user:id,name'])->orderBy('count', 'desc')
    ->limit(2)->offset(1)->get();
    $list = Story::with(['category', 'user:id,name'])->orderBy('count', 'desc')
    ->limit(6)->offset(3)->get();

    $sideStories = array('list' => $list, 'highlights' => $highlights);
    $stories = array('mainStory' => $mainStory, 'sideStories' => $sideStories);
   
    return response()->json($stories);
  }

  public function store(Request $request) {
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
      $this->storageImage($request->image, str_replace('uploads/', '', $request->imagePath));
    }
    $request->merge(['image' => $request->imagePath]);
    $story = Story::find($id);
    if ($request->user()->id !== $story->user_id) {
      return response()->json(['error' => 'Você só pode editar suas proprias historias.'], 403);
    }
    $story->update($request->all());
    return response()->json('Story updated!');
  }

  private function storageImage($base64, $name = null) {
    $image = str_replace('data:image/png;base64,', '', $base64);
    $image = str_replace(' ', '+', $image);
    $imageName = $name ? $name : str_random(20).'.png';
    \File::put(storage_path(). '/app/public/uploads/' . $imageName, base64_decode($image));
    return $imageName;
  }

  public function show($id) {
    $story = Story::with(['category', 'user:id,name'])->find($id);
    return $story ? $story->toJson() : response()->json(['error' => 'Nenhuma história foi encontrada'], 404);
  }
  public function view($id) {
    $story = Story::with(['category', 'user:id,name'])->find($id);
    $story->update(['count' => ++$story->count]);
    return $story ? $story->toJson() : response()->json(['error' => 'Nenhuma história foi encontrada'], 404);
  }
  public function destroy($id) {
    $story = Story::find($id);
    $story->delete();
    return 'Story deleted';
  }
}
