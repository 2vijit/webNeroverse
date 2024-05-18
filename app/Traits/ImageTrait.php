<?php
namespace App\Traits;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

trait ImageTrait
{
   public function saveImage($image, $height = null, $lenght = null)
   {
        if(isset($image)){
            $current_date = Carbon::now()->format('d-m-Y');

            if(!File::isDirectory('public/uploads/images/' . $current_date)){
                File::makeDirectory('public/uploads/images/' . $current_date, 0777, true, true);
            }

            $img_extention = str_replace('image/', '', Image::make($image)->mime());

            if($height != null && $lenght != null){
                $img = Image::make($image)->resize($height, $lenght);
            }else{
                $img = Image::make($image);
            }

            $img_name = 'public/uploads/images/' . $current_date . '/' . uniqid() . '.' . $img_extention;

            $img->save($img_name);
            return $img_name;

        }

       return null;
   }

   public function deleteImage($url)
   {
       if (isset($url)) {
           if (File::exists('admin/'.$url)) {
               File::delete('admin/'.$url);
               return true;
           }
           return false;
       }
       return null;
   }

   // saveImage function with directory - Asif

    /**
     * Save the uploaded image in the given directory and return the location.
     *
     * @param string $folder_name
     * @param $image
     * @param int|null $width
     * @param int|null $height
     * @return string|null
     */
    public function save_image(string $folder_name, $image, int $width = null, int $height = null): ?string
    {
        if (isset($image)) {
            if (!File::isDirectory('public/' . $folder_name)) {
                File::makeDirectory(('public/' . $folder_name), 0777, true, true);
            }

            if ($width !== null && $height !== null) {
                $img = Image::make($image)->resize($width, $height);
            } else {
                $img = Image::make($image);
            }

            $img_extension = $image->getClientOriginalExtension();
            $location = 'public/' . $folder_name . '/' . uniqid('', false) . '.' . $img_extension;
            $img->save($location);
            return $location;
        }

        return null;
    }
}
