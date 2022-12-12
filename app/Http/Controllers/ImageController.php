<?php

namespace App\Http\Controllers;

use App\Http\Helper\MessagesHelper;
use App\Http\Helper\UploadHelper;
use App\Http\Requests\ImageRequest;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use UploadHelper;


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($album_id)
    {
        $album = Album::whereUserId(auth()->id())
        ->select('id','name')
        ->findOrfail($album_id);
        return view('images.create',compact('album'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImageRequest $request , $album_id)
    {
        $album = Album::whereUserId(auth()->id())
        ->select('id')
        ->findOrfail($album_id);

        $image = $this->uploadSingleFile('albums', request()->file('image'));

        $data = [
            'name'=>$request->name,
            "album_id"=> $album->id,
            "image"=>$image
        ];

        Image::create($data);
        return response()->json([
            'message'=> MessagesHelper::CREATED_SUCCESSFULLY
        ],200);

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = Image::findOrfail($id);

        $this->authorize('update', $image);
        $album = Album::select('id','name')->findOrfail($image->album_id);

        return view('images.edit', compact('image','album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ImageRequest $request, $id)
    {
        $image = Image::findOrfail($id);

        $this->authorize('update', $image);

        $image_name = null;
        if(request()->file('image')){
            $image_name = $this->uploadSingleFile('albums', request()->file('image'));
           // delete old image
            $this->deleteFile('albums', $image->image);
        }

        $data = [
            'name'=>$request->name,
        ];
        if($image_name){
            $data["image"] = $image_name;
        }

        $image->update($data);
        return response()->json([
            'message'=> MessagesHelper::UPDATED_SUCCESSFULLY
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::findOrfail($id);

        $this->authorize('delete', $image);

        $this->deleteFile('albums', $image->image);
        $image->delete();
        toastr()->success(MessagesHelper::DELETED_SUCCESSFULLY, 'success');
        return back();
    }
}
