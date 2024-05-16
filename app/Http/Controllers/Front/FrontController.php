<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use Illuminate\Support\Facades\Blade;
class FrontController extends Controller
{
    public function index(){
        $products = Product::with('media')->get();
        // dd($products);
        return view('user.home',compact('products'));
    }
    public function productDetail(Request $request){
        $product = Product::where('slug',$request->slug)->first();
        if(!$product){
            abort(404);
        }
        return view('user.product_detail',compact('product'));
    }
    public function cartView(Request $request){
        if(!Auth::check()){
            return response()->json(['status' => false],401);
        }
        return response()->json(['status' => true],200);
    }
    public function cart(Request $request){
        $cartDetails = [];
        if($request->session()->has('cart')){
            $cartDetails = $request->session()->get('cart');
        }
        return view('user.cart',compact('cartDetails'));
    }
    public function addToCart(Request $request){
        
        // $request->session()->remove('cart');
        // $request->session()->forget('cart');
        // return 'true';
        if(Auth::check()){
            $product = Product::where('id',$request->product_id)->first();
            if($product){
                $cart = [];
                $cartVal = array('product_id' => $request->product_id , 'qty' => $request->qty);
                if ($request->session()->has('cart')) {
                    $cartData = $request->session()->get('cart');
                    $productExists = false;
                    foreach($cartData as $key => $c){
                        if($c['product_id'] == $request->product_id){
                            $qty = $c['qty'] + $request->qty;
                            $newCartVal = array('product_id' => $request->product_id , 'qty' => $qty);
                            $cartData[$key] = $newCartVal;
                            $productExists = true;
                            break;
                        }
                    }
                    if(!$productExists){
                        $request->session()->push('cart', $cartVal);
                    }else{
                        $request->session()->put('cart',$cartData);
                    }
                }else{
                    $cart[] = $cartVal;
                    $request->session()->put('cart',$cart);
                }
                $cartItem = $request->session()->get('cart');
                $cartQty = 0;
                foreach($cartItem as $c){
                    $cartQty += $c['qty'];
                }
                return response()->json(['status' => true,'message'=>'Item added to cart succesfully', 'title'=>'Cart updated.' , 'cart_qty' => $cartQty],201);
            }else{
                return response()->json(['status' => false,'message'=>'Product not found'],401);
            }
        }
    }
    public function removeFromCart(Request $request){
        // $request->session()->forget('name');
        // return $request->all();
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart');
            foreach($cart as $key => $c){
                if($c['product_id'] == $request->product_id ){
                    unset($cart[$key]);
                }
            }
            $cartQty = 0;
            foreach($cart as $c){
                $cartQty += $c['qty'];
            }
            $request->session()->put('cart',$cart);
            $cartTotal = Blade::render('user._partials.cart_total');
            
            return response()->json(['status' => true,'title'=>'Cart Updated','message' => 'Cart item removed.','cart_qty' => $cartQty , 'cart_total' => $cartTotal],201);
        }else{
            return response()->json(['status' => false,'message'=>'Cart not found'],401);
        }
    }

    public function updateCart(Request $request){
        try{
            $data =  $request->all();
            $cart = [];
            $cartQty = 0;
            foreach($data as $product_id => $qty){
                if($qty > 0){
                    $cart[] = [
                        'product_id' => $product_id,
                        'qty' => $qty
                    ];
                    $cartQty += $qty; 
                }
            }
            $request->session()->put('cart',$cart);
            $cartTotal = Blade::render('user._partials.cart_total');
            return response()->json([ 
                                    'status' => true,
                                    'title'=>'Cart Updated',
                                    'message' => 'Cart item updated.',
                                    'cart_qty' => $cartQty,
                                    'cart_total' => $cartTotal], 201);
        }catch(\Exception $e){
            return response()->json(['status' => false,'message'=> $e->getMessage()]);
        }
    }

    public function searchProduct(Request $request){
        try{
            $query = $request->input('query');
            $products = [];
            if(isset($query)){
                $products = Product::where('name','LIKE',"%$query%")
                            ->orWhere('price','LIKE',"%$query%")
                            ->get();
            }
          
            return view('user.search_products',compact('products','query'));
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message' => $e->getMessage()]);
        }
    }
}
