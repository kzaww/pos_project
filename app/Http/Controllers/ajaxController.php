<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\View;
use App\Models\Product;
use App\Models\order_list;
use Illuminate\Http\Request;

class ajaxController extends Controller
{
    //get sort data
    public function list(Request $request)
    {
        if($request->status == 'Asc'){
            $data = Product::orderBy('created_at','asc')->get();
        }elseif($request->status == 'Desc'){
            $data = Product::orderBy('created_at','desc')->get();
        }elseif($request->status == 'atoz'){
            $data = Product::orderBy('product_name','asc')->get();
        }
        return $data;
    }

    //get category filter
    public function category(Request $request)
    {
        $data = Product::where('category_id',$request->status)->get();
        return $data;
    }

    //get price filter
    public function price(Request $request)
    {
        if($request->status == '1'){
            $data = Product::where('product_price','<','20000')->get();
        }elseif($request->status == '2'){
            $data = Product::whereBetween('product_price',['20000','30000'])->get();
        }elseif($request->status == '3'){
            $data = Product::where('product_price','>','30000')->get();
        }
        return $data;
    }

    //insert cart data
    public function cart(Request $request)
    {
        $data = $this->cartdataformat($request->data);

        if($request->data['quantity'] > 0 ){
            Cart::create($data);

            return response()->json([
                'status' => '200',
            ]);
        }else{
            return response()->json([
                'status' => '505',
            ]);
        }
    }

    //clear cart
    public function clearCart(Request $request){
        if($request->data == 'clear'){
            Cart::where('user_id',auth()->user()->id)->delete();
            return response()->json([
                'status' => '200'
            ]);
        }
    }

    //clear single line
    public function clearSingle(Request $request){
        Cart::where('product_id',$request->product_id)
            ->where('created_at',$request->created_at)
            ->delete();
    }

    //orderList input
    public function orderList(Request $request)
    {
        $total = $request->totalval['total_price'];
        if(count($request->orderList)>0){
            foreach($request->orderList as $item){
                $data = order_list::create($item);
            }

            Order::create([
                'user_id' => $data->user_id,
                'total_price'=> (int)$total,
                'order_code' => $data->order_code
            ]);

            Cart::where('user_id',$data->user_id)->delete();
        }
        return response()->json([
            'status' => 'success',
            'order' => 'success'
        ]);
    }

    //add view Count
    public function viewCount(Request $request)
    {
        $data = Product::where('product_id',$request->product_id)->first();

        Product::where('product_id',$request->product_id)->update(['view_count' => $data['view_count']+1]);
        View::create([
            'user_id' => $request->user_id,
            'product_id' =>$request->product_id
        ]);

        return response()->json([
            'message'=>'success'
        ],200);
    }

    //format cart data
    private function cartdataformat($data)
    {
        return [
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity']
        ];
    }
}
