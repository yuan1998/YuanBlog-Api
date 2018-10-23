<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Image;


trait ImageTrait {

    /**
     * [$allowed_ext description]
     * @var [type]
     */
    public static $allowed_ext = ['png','jpg','gif','jpeg'];


    /**
     * save Upload File TO storage.
     *
     * @param      $file
     * @param      $folder
     * @param      $file_prefix
     * @param bool $maxWidth
     * @return array|boola
     */
    public static function saveImage ($file , $folder , $file_prefix , $maxWidth = false)
    {

        $folder_name = "images/$folder/". date("Ym/d",time());

        $ext         = strtolower($file->getClientOriginalExtension()) ?: 'png';

        $filename    = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $ext;

        if(!in_array($ext,static::$allowed_ext)){
            return false;
        }

        $filePath = $file->storeAs($folder_name , $filename);

        if($maxWidth && $ext != 'git'){
            static::reduceImage($maxWidth , $filePath);
        }


        return $filePath;

    }


    /**
     * Reduce Image Size.
     *
     * @param $maxWidth
     * @param $filePath
     */
    public static function reduceImage ($maxWidth , $filePath)
    {
        $filePath = Storage::getAdapter()->getPathPrefix().$filePath;

        $img = Image::make($filePath);

        $img->resize($maxWidth,null, function ($constraint) {
            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        $img->save();
    }

}
