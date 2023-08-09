<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function index(){
        $categories = Category::all();
        if (count($categories)==0){
            return response()->json("There are no categories yet",404);
        }
        return response()->json($categories,200);
    }

    public function getOne($id){
        
        $category = Category::find($id);
        if ($category != null){
            return response()->json($category,200);
        }
        return response()->json(['There is no such category'],404);
    }

    public function getProducts($cat){
        
            $category = Category::find($cat);
            if($category != null){

                $products = $category->products;
                
                if(count($products) != 0){
                    return response()->json($products,200);
                }else{
                    return response()->json("No products in this category yet",404);
                }
            }
            return response()->json("No such category",404);
        
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'string|required',
            'image'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],422);
        }

        if($request->hasFile('image')){
            $image = $request->file('image');
            $path = $image->store('category_images','public');
            $category = Category::create([
                'name'=>$request->input('name'),
                'image'=>$path
            ]);
    
            return response()->json(['message'=>'category created successfully','category'=>$category],200);
        }
        
    }

    public function update(Request $request,$id){
        
        $validator = Validator::make($request->all(),[
            'name'=>'string|required',
            'image'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()],422);
        }
        
        $category = Category::find($id);
        if ($category){
            if($request->hasFile('image')){
                $image = $request->file('image');
                $path = $image->store('category_images','public');
                $category->name = $request->input('name');
                $category->image = $path;
                $category->save();
                return response()->json(['message'=>'category updated successfully','category'=>$category],200);
            }
            return response()->json("No file chosen",422);
        }
        else{
            return response()->json(['message'=>'There is no such category'],404);
        }



        
    }

    public function delete($id){
        $category = Category::find($id);
        if($category != null){
            $category->delete();
            return response()->json("category deleted successfully",200);
            }
            return response()->json("category not found",404);
    }
}
