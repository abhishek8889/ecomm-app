<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductMedia;
use App\Models\Media;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\CentralLogics\Helpers;
class ProductController extends Controller
{
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|max:255|min:3',
                'description' => 'required',
                'price' => 'required',
                'brand' => 'required',
                'quantity' => 'required|numeric'
            ]);
            if($validator->fails()){
                if ($validator->fails()) {
                    throw new \Illuminate\Validation\ValidationException($validator);
                }
            }
            $media_id = [];
            $mediaDetails = [];
            if($request->hasFile('image')){
                $directory = "products";
                $files = $request->file('image');
                foreach($files as $file){
                    $mediaObj = Media::saveMedia($file,$directory); 
                    if(!empty($mediaObj) && $mediaObj['status'] == true ){
                        $media_id[] = $mediaObj['media']->id;
                        $mediaDetails[] = $mediaObj['media'];
                    }
                }
            }

            $slug = Helpers::generateUniqueChar($request->name , 4);
            $sku = Helpers::generateUniqueChar('PROD', 4);
            
            $product = Product::create([
                'name' => $request->name,
                'slug' => $slug,
                'brand' => $request->brand,
                'key_words' => $request->keywords,
                'description' => $request->description,
                'price' => $request->price,
                'sku' => $sku,
                'quantity' => $request->quantity,
            ]);
            $product->media()->attach($media_id); 
            $product->media = $mediaDetails;
            if($product){
                return response()->json(['status' => true,'message' => 'Product created successfully' , 'product' => $product],201);
            }else{
                return response()->json(['status' => true,'message' => 'Product creation failed'],401);
            }
        }catch(\Exception $e){
            throw $e;
            // return response()->json(['status'=>false,'message'=>'Something went wrong','errors'=>$e->getMessage()],500);
        }
    }

    public function list(Request $request){
        try{
            $products = Product::with('media')->paginate(10);
             
            return response()->json(['status' => true , 'products' => $products] ,200);
        }catch(\Exception $e){
            throw $e;
        }
    }
    public function detail(Request $request){
        try{
            if($request->slug){
                $product = Product::where('slug',$request->slug)->first();
                if($product){
                    $product = Product::with('media')->find($product->id);
                    return response()->json(['status' => true , 'product' => $product],200);
                }else{
                    throw new NotFoundHttpException();
                }
            }
        }catch(\Exception $e){
            throw $e;
        }
    }
    public function findProduct(Request $request){
        $query = $request->input('query'); 
        try{
            if(isset($query)){
                $products = Product::with('media')->where('name','LIKE',"%$query%")
                            ->orWhere('price','LIKE',"%$query%")
                            ->get();
                if(count($products) > 0){
                    return response()->json(['status' => true , 'products'=> $products],200);
                }else{
                    return response()->json(['status' => false ,'message'=> 'No data found.', 'products'=> []],200);
                }
            }else{
                throw new NotFoundHttpException();
            }
        }catch(\Exception $e){
            throw $e;
        }
    }
}
