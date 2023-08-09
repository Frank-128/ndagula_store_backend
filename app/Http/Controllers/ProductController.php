<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::all();
        if (count($products)==0){
            return response()->json("There are no products yet",404);
        }
        return response()->json($products,200);
    }
    public function getOne($id){
        
        $product = Product::find($id);
        if ($product != null){
            return response()->json($product,200);
        }
        return response()->json(['There is no such product'],404);
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'string|required',
            'price'=>'required',
            'category'=>'required',
            'amount'=>'required',
            'rating'=>'required',
            'colors'=>'required',
            'size'=>'required',
            'image'=>'required',

        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],422);
        }
        if($request->hasFile('image')){
            $image = $request->file('image');
            $path= $image->store('product_images','public');
        }
        $product = Product::create([
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'amount'=>$request->input('amount'),
            'rating'=>$request->input('rating'),
            'colors'=>$request->input('colors'),
            'size'=>$request->input('size'),
            'image'=>$path
        ]);
        $arr = explode(',',$request->input('category'));
        $product->categories()->attach($arr);
        $product->save();

        return response()->json(['message'=>'product created successfully','product'=>$product],200);
    }

    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'name'=>'string|required',
            'price'=>'required',
            'amount'=>'required',
            'rating'=>'required',
            'colors'=>'required',
            'size'=>'required',
            'image'=>'required',

        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],422);
        }
        $product = Product::find($id);

        if($product != null){
            if($request->hasFile('image')){

                $image = $request->file('image');
                $path= $image->store('product_images','public');

                $product->name = $request->input('name');
                $product->price= $request->input('price');
                $product->amount=$request->input('amount');
                $product->rating=$request->input('rating');
                $product->colors=$request->input('colors');
                $product->size=$request->input('size');
                $product->image=$path;
                
                $product->save();
                return response()->json(['message'=>'product updated successfully','product'=>$product],200);
            }
            return response()->json("No file chosen",422);
        }



    }

    public function delete($id){
        $product = Product::find($id);
        if($product != null){
            $product->delete();
            return response()->json("product deleted successfully",200);
            }
            return response()->json("Product not found",404);
    }

}
