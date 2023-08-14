<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    // creating a new order
    public function createOrder(Request $request)
    {
        $order = Order::create(['user_id' => $request->input('user_id')]);


        try {
            $products  = $request->input('products');

            foreach ($products as $product) {

                // $order->products()->attach($request->input('prod_id'),['colors'=>$product->colors,'size'=>$product->size,'amount'=>$product->amount]);
                $order->products()->attach($product["prod_id"], ['colors' => $product["colors"], 'size' => $product["size"], 'amount' => $product["amount"]]);
            }
            $order->save();



            return response()->json(["order" => "order submitted successfully"], 200);
        } catch (Exception $exc) {
            // echo $exc;
            $products  = $request->input('products');

            //    echo $products;
            return response()->json(["err" => $products[0]["prod_id"]], 400);
        }
    }
}
