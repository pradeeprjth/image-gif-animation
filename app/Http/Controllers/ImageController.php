<?php

namespace App\Http\Controllers;

use File;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\GIFEncoder;

class ImageController extends Controller
{
    public function uploadImages(Request $request)
    {

        // if ($request->hasFile('images')) {
        //     // foreach($request->file('images') as $image){
        //     // $name = time().'.'.$image->getClientOriginalExtension();
        //     // $destinationPath = public_path('/images/');
        //     // $image->move($destinationPath, $name);
        //     // $imageVar->url = $destinationPath."/".$name;
        //     //this statement will loop through all files.
                $images = $request->file('images');
        //          //Get file original name
        //          // move files to destination folder
        //          $framed[] = 5;
        //          $gif = new GIFEncoder	($images,$framed,0,2,0, 0, 0,"url");
        //          Header ( 'Content-type:image/gif' );
        //          Log::info($gif->GetAnimation());
                
            
              
        // }
        if (isset($this->animation)) {
            return $this->animation;
        }
        check_condition($this->IMAGES, 'No images for gif');
        PsLibs::inst()->GifEncoder();
        $frames = array();
        $framed = array();
        foreach ($this->IMAGES as $path => $delay) {
            ob_start();
            SimpleImage::inst()->load($path)->output(IMAGETYPE_GIF)->close();
            $frames[] = ob_get_contents();
            $framed[] = $delay;
            // Delay in the animation.
            ob_end_clean();
        }
        // Generate the animated gif and output to screen.
        $gif = new GIFEncoder($frames, $framed, 0, 2, 0, 0, 0, 'bin');
        $this->animation = $gif->GetAnimation();
        return $this->animation;
    }

}
