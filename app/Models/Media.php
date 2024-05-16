<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;
use App\Models\Product;


class Media extends Model
{
    use HasFactory;
    protected $fillable = ['name','directory_path','image_url'];
    public function product(){
        return $this->belongsToMany(Product::class,'product_media');
    }
    public static function saveMedia($file,$directory){
        try{
            $file_name = time().rand(1000,9999).$file->getClientOriginalName();
            if($url = $file->storeAs($directory,$file_name,'public')){
                $media = self::create([
                    'name' => $file_name,
                    'directory_path' => $directory,
                    'image_url' => $url,
                ]);
                return array('status' => true , 'media' => $media);
            }
        }catch(\Exception $e){
            return array('status' => false, 'message' => $e->getMessage());
        }
    }
}
