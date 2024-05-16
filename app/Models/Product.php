<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;
class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','key_words','sku','brand','description','media_id','price','quantity'];
    public function media(){
        return $this->belongsToMany(Media::class,'product_media');
    }
}
