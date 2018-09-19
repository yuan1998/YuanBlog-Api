<?php
namespace App\Traits;

use Image;


trait ImageTrait {


    public $allowedExtension = ['png' , 'jpg' , 'gif' ,'jpeg'];


    /**
     * @param $file
     * @param $folder
     * @param $filePrefix
     * @param bool $size
     * @return array|bool
     */
    public function saveImage ($file , $folder, $filePrefix , $size = false)
    {

        $time = time();
        // /uploads/images/avatars/201809/21/
        $folderName = "/uploads/images/$folder/" . date("Ym/d",$time);

        $uploadPath = public_path() . $folderName;


        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';


        $filename = "{$filePrefix}_{$time}_" . str_random(10) . ".$extension";

        if( ! in_array($extension,$this->allowedExtension))
            return false;

        $file->move($uploadPath , $filename);

        if((int) $size && $extension != 'gif')
            $this->reduceSize("$uploadPath/$filename",(int) $size);

        return [
            'path' => "$folderName/$filename" ,
        ];

    }


    /**
     * @param $filePath
     * @param $size
     */
    public function reduceSize ($filePath , $size)
    {
        $image = Image::make($filePath);
        $image->resize($size , null , function ( $constraint ) {
            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        $image->save();

    }

}
