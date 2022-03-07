<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    //
    function index()
    {
        $data=Product::all();
        return view('product',['products'=>$data]);
    }

    function detail($id)
    {
        $data= Product::find($id);
        return view('detail',['product'=>$data]);
    }

    function search(Request $req)
    {
       // return $req->input();
      $data= product::
     where('name','like','%'.$req->input('query').'%')->get();
     return view('/search',['product'=>$data]);
    }

    function addTocart(Request $req)
    {
        if($req->session()->has('user'))
         {  $a=$req->session()->has('user');
           // print_r($a);
             $cart=new Cart;
             $cart->user_id=$a;
             $cart->product_id=$req->product_id;
             $cart->save();
             return redirect('/index');
         }
         else
        {
        return redirect('/login');
        }
    }
      static function cartItem()
    {
       $userId=Session::get('user')['id'] ;
       return Cart::where('user_id',$userId)->count();
    }
        function cartlist()
        {
           $userId=Session::get('user')['id'];
           $products= DB::table('cart')
           ->join('products','cart.product_id','=','products.id')
           ->where('cart.user_id',$userId)
           ->select('products.*')
           ->get();

           return view('cartlist',['products'=>$products]);
        }
}
