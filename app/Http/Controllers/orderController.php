<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class orderController extends Controller
{
    //direct order list page
    public function list()
    {
        $data = Order::Select('orders.*','users.name')
                    ->leftjoin('users','orders.user_id','users.id')
                    ->orderBy('orders.status','asc')
                    ->paginate(5);

        return view('admin.order.orderList',compact('data'));
    }

    //order detail
    public function listDetails($code)
    {
        $data = DB::table('order_lists')->select('order_lists.*','products.product_image','products.product_name as name','users.name')
                ->leftJoin('products','products.product_id','order_lists.product_id')
                ->leftJoin('users','order_lists.user_id','users.id')
                ->where('order_lists.order_code',$code)
                ->get();

        // dd($data->toArray());
        return view('admin.order.orderListDetails',compact('data'));
    }

    //recive and emit data from ajax
    public function ajaxList(Request $request)
    {
        Order::where('order_id',$request->order_id)
            ->update([
                'status' => $request->status
            ]);

        if($request->status == '0'){
            return response()->json([
                'message'=>'pending'
            ],200);
        }elseif($request->status == '1'){
            return response()->json([
                'message'=>'success'
            ],200);
        }elseif($request->status == '2'){
            return response()->json([
                'message'=>'reject'
            ],200);
        }
    }

    //custom pagination
    public function pagination(Request $request)
    {
        if($request->data){
            $data=Order::Select('orders.*','users.name')
                    ->leftjoin('users','orders.user_id','users.id')
                    ->where('orders.order_code','like','%'.$request->data.'%')
                    ->orderBy('status','asc')
                    ->paginate(5);

            return view('admin.order.orderPagination',compact('data'))->render();
        }else{
            $data = Order::Select('orders.*','users.name')
                        ->leftjoin('users','orders.user_id','users.id')
                        ->orderBy('orders.status','asc')
                        ->paginate(5);

            return view('admin.order.orderPagination',compact('data'))->render();
        }

    }

    //search data
    public function ajaxTotalSearch(Request $request)
    {
        $search=Order::Select('orders.*','users.name')
                    ->leftjoin('users','orders.user_id','users.id')
                    ->where('orders.order_code','like','%'.$request->data.'%')
                    ->orderBy('status','asc')
                    ->paginate(5);

        $count = $search->total();
        if($search){
            return response()->json([
                'count' => $count,
            ],200);
        //     $i = 1;
        //     foreach($search as $item){
        //         $data .='<tr class="align-middle tb_content">'.
        //             '<td>'. $i .'</td>'.
        //             '<td class="order_id" hidden>'. $item->order_id .'</td>'.
        //             '<td class="name">'. $item->name .'</td>'.
        //             '<td>'. $item->created_at->format('j/M/Y h:i:s') .'</td>'.
        //             '<td><a href="'. route('admin#orderDetails',$item->order_code).'" class="text-decoration-none">'.$item->order_code.'</a></td>'.
        //             // '<td>'. $item->order_code .'</td>'.
        //             '<td>'. $item->total_price  .'Kyats</td>'.
        //             '<td>
        //                 <div class="dropdown1" data-dropdown>';

        //     switch($item->status){
        //         case 0 : $data.='<button class="icon align-middle dddd bg-warning text-white" title="Change Status" data-dropdown-button>Pending</button>';break;
        //         case 1 : $data.='<button class="icon align-middle dddd bg-success text-white" title="Change Status" data-dropdown-button>Success</button>';break;
        //         case 2 : $data.='<button class="icon align-middle dddd bg-danger text-white" title="Change Status" data-dropdown-button>Rejected</button>';break;
        //     }

        //     $data .= '<ul class="dropdown_content1" style="z-index:9999;height:80px;padding:0;">
        //                 <li class="status_change" data-status="0">Pending...</li>
        //                 <li class="status_change" data-status="1">Success</li>
        //                 <li class="status_change" data-status="2">Reject</li>
        //             </ul>
        //             </div>
        //             </td>
        //             </tr>';
        //     $i++;
        // }

        }
    }

    //data search
    public function ajaxDataSearch(Request $request)
    {
        $data=Order::Select('orders.*','users.name')
                    ->leftjoin('users','orders.user_id','users.id')
                    ->where('orders.order_code','like','%'.$request->data.'%')
                    ->orderBy('status','asc')
                    ->paginate(5);

        if(count($data) >= 1 ){
            return view('admin.order.orderPagination',compact('data'))->render();
        }else{
            return response()->json([
                'message' => 'zero'
            ]);
        }
    }
}
