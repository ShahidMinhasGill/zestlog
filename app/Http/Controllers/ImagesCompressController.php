<?php

namespace App\Http\Controllers;

use App\Traits\ZestLogTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Symfony\Component\Console\Input\Input;

class ImagesCompressController extends Controller
{
    use ZestLogTrait;

    public function showUploadForm()
    {
//         change variable  $destinationPathNew
//        $data = base64_decode(preg_replace('/^data:image\/\w+;base64,/i', '', $request->input('log_pic')));
//        $fileName = createImageUniqueName('jpg');
//        $destinationPath = public_path(MobileUserLogImagePathTemp);
//        if (!file_exists($destinationPath)) {
//            mkdir($destinationPath, 0777, true);
//        }
//        $tempFile = $destinationPath .'/'. $fileName;
//        file_put_contents($tempFile, $data);
//
//        $imagePath = $tempFile;
//        ini_set('memory_limit', '1024M');
//
//        list($this->originalImageWidth, $this->originalImageHeight) = getimagesize($imagePath);
//
//        $this->requiredImageHeight = ($this->originalImageHeight - ($this->originalImageHeight) * 0.25);
//        $this->requiredImageWidth = ($this->originalImageWidth - ($this->originalImageWidth) * 0.25);
//        $this->calculateImageDimension();
//        $ImageUpload = Image::make($imagePath);
//        $savePath = $destinationPathNew;
//        $ImageUpload->resize($this->newImageHeight,$this->newImageWidth,function ($constraint) {
//            $constraint->aspectRatio();
//            $constraint->upsize();
//        })->save($savePath . '/' .$fileName);
//        unlink($tempFile);
//
//        return $fileName;
    }
}
