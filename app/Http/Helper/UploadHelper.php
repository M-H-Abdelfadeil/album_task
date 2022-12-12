<?php
namespace App\Http\Helper;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait UploadHelper{

    /**
     * upload single image
     *
     * @param string $dir
     * @param  $file
     *
     * @return string $filename
     */
    public function uploadSingleFile(string $dir  , $file){

        if (!Storage::disk('public')->exists($dir)) {
            Storage::disk('public')->makeDirectory($dir);
        }
        //$note_img = Image::make($file)->stream();
        $extenstion= $file->getClientOriginalExtension();
        $file_name = $this->randomNameFile() .".". $extenstion;

        Storage::disk('public')->putFileAs($dir ."/", $file,$file_name);
        return $file_name;
    }


    /**
     * delete file
     *
     * @param string $dir
     * @param string $filename
     *
     * @return bool
     */
    public function deleteFile(string $dir , string  $filename){
        if (Storage::disk('public')->exists($dir.'/' . $filename)) {
            Storage::disk('public')->delete($dir.'/' . $filename);
            return true;
        }else{
            return false;
        }
    }


    private function randomNameFile(){
        return Str::random(20).time();
    }


    // delete



}
