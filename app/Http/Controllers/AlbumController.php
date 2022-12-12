<?php

namespace App\Http\Controllers;

use App\Http\Helper\MessagesHelper;
use App\Http\Helper\UploadHelper;
use App\Http\Requests\AlbumRequest;
use App\Http\Requests\DeleteAlbumRequest;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    use UploadHelper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::whereUserId(auth()->id())
                        ->select('name', 'id', 'created_at')
                        ->withCount('images')
                        ->get();
        return view('dashboard',compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('albums.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AlbumRequest $request)
    {

        // validation album name => AlbumRequest

        // validation images

        $request->validate($this->rulesImages($request['arr_numbers'])); //$request['arr_numbers'] = request names

        //create album

        $album = Album::create([
            'name'=>$request->name,
            'user_id'=>auth()->id()
        ]);

        // upload images
        $images = $this->getImages($request);

        // insert images
        $album->images()->createMany($images);

        // return response
        return response()->json([
            'message'=> MessagesHelper::CREATED_SUCCESSFULLY
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album = Album::with(['images'=>function ($q) {
            $q->select('id', 'name', 'image', 'album_id');
        }])->whereUserId(auth()->id())
           ->findOrfail($id);


        return view('albums.show', compact('album'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $album = Album::whereUserId(auth()->id())
                            ->findOrfail($id);
        return view('albums.edit',compact('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumRequest $request, $id)
    {
        $album = Album::whereUserId(auth()->id())
        ->findOrfail($id);

        $album->update(['name' => $request->name]);
        toastr()->success(MessagesHelper::UPDATED_SUCCESSFULLY, 'success');
        return back();
    }

    public function status_delete( $id){
        $albums= Album::where('id','!=', $id)->select('id','name')->get();
        $album = Album::whereUserId(auth()->id())
        ->select('id','name')
        ->findOrfail($id);
        return view('albums.status-delete', compact('album','albums'));

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteAlbumRequest $request, $id)
    {


        $msg="The album and photos have been deleted successfully";

        $album = Album::whereUserId(auth()->id())
                ->findOrfail($id);
        if($request->status=="delete"){
            foreach($album->images as $image){
                $this->deleteFile('albums', $image->image);
            }
        }else{
            $new_album= Album::whereUserId(auth()->id())
                        ->where('id','!=', $id)
                        ->findOrfail($request->album_move);
            if(!$new_album){
                return redirect()->back()->withErrors(['album_move'=>'invalid']);
            }
            Image::whereAlbumId($album->id)->update(['album_id' => $new_album->id]);
            $msg ="The album has been deleted successfully and the photos have been moved to the album " .$new_album->name;

        }
        $album->delete();
        toastr()->success($msg, "success");
        return redirect()->route('albums.index');

    }

    /**
     * upload images
     * @param Request $request
     * @return array<array>
     */
    private function getImages($request){
        $images = [];
        $numbers =  explode(',' , $request['arr_numbers']);
        foreach($numbers as $num){
            $img = $this->uploadSingleFile("albums", $request->file("image_$num"));

            $images[] = [
                "image"=>$img,
                "name"=>$request["image_name_$num"]
            ];
        }

        return $images;
    }

     /**
      * function make rules validation to images
      *
      * @param string $numberReques
      * @return array
      */

    private function rulesImages(string $numberReques){
        $numbers =  explode(',' , $numberReques);
        $rules = [];
        foreach($numbers as $num){
            $rules["image_name_$num"] = "required|string|max:255";
            $rules["image_$num"] = "required|mimes:jpeg,jpg,png|max:2048";
        }
        return $rules;
    }


}
