<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getImagesAttribute ($value)
    {
        $modifiedImages = [];
        $value = json_decode($value);
        if($value!=null){
            $allImages = explode(",",$value);
            foreach ($allImages as $image) {
                $modifiedImages [] = asset('product_images/'.$image);
            }
        }
        return count($modifiedImages) > 0 ? $modifiedImages : null ;
    }
    public function setImagesAttribute ($value)
    {
        $this->attributes['images'] =  json_encode(implode(",",$value));
    }

}
