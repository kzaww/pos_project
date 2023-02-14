<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    //direct user page
    public function user()
    {
        $data = Product::get();
        $category = Category::get();
        $cart = Cart::where('user_id',auth()->user()->id)->get();
        // dd(gettype($cart));
        return view('user.home')->with(['data'=>$data,'category'=>$category,'cart' => $cart]);
    }

    //direct account page
    public function account()
    {
        $cart = Cart::where('user_id',auth()->user()->id)->get();
        return view('user.account',compact('cart'));
    }

    //change profile
    public function changeProfile(Request $request)
    {
        $id = auth()->user()->id;
        $validator=Validator::make($request->all(),[
            'name' => 'required',
            'email' => "required|email|unique:users,email,$id,id",
            'phone' => 'required|max:11',
            'address' => 'required'
        ]);

        if($validator->fails()) {
            return back()
                        ->with('updateFail','Something is wrong,Try Again!')
                        ->withErrors($validator)
                        ->withInput();
        };

        $id = $request->id;

        $data = $this->updatedUserData($request->all());
        User::where('id',$id)->update($data);
        return back()->with('updateSuccess','Successfully Updated');
    }

    //upload Image
    public function uploadImage(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'image' => 'required|mimes:png,jpg,jpeg,webp|file',
        ]);

        if($validator->fails()){
            return back()->with('uploadFail','Image Upload Fail!,Try Again')
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = User::where('id',auth()->user()->id)->first();
        $dbImage = $data['image'];
        $image = $request->image;
        $imageName = uniqid().'_'.$image->getClientOriginalName();
        // dd($imageName);

        if($dbImage == null){
            $image->move(public_path().'/admin/userImage/',$imageName);
        }else{
            if(File::exists(public_path('/admin/userImage/'.$dbImage))){
                File::delete(public_path('/admin/userImage/'.$dbImage));
            }
            $image->move(public_path().'/admin/userImage/',$imageName);
        }
        User::where('id',auth()->user()->id)->update(['image'=>$imageName]);

        return back()->with('uploadSuccess','Image Upload Success');
    }

    //change Password
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'newPassword' => 'required|min:6',
            'oldPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword|min:6'
        ]);
        if($validator->fails()) {
            return back()
                        ->with('changeFail','Credial does not match')
                        ->withErrors($validator)
                        ->withInput();
        };
        $id = $request->id;
        $data = User::where('id',$id)->first();
        $oldPass = $request->oldPassword;
        $newPass = $request->newPassword;
        $dbPass = $data->password;
        if(Hash::check($oldPass, $dbPass)){
            $hash = Hash::make($newPass);
            User::where('id',$id)->update([
                'password' => $hash
            ]);
            return back()->with('passwordSuccess','Change Password Successfully');
        }else{
            return back()->with('passwordFail','Change Password Fail,Try Again');
        }
    }

    //detail page
    public function details($id)
    {
        $data = Product::where('product_id',$id)->first();
        $all = Product::inRandomOrder()->limit(5)->get();
        $cart = Cart::where('user_id',auth()->user()->id)->get();
        return view('user.details')->with(['data'=>$data,'product'=>$all,'cart'=>$cart]);
    }

    //cart page
    public function cart()
    {
        $cart = Cart::select('carts.*','products.product_price as price','products.product_name as name')
                    ->leftjoin('products','products.product_id','carts.product_id')
                    ->where('user_id',auth()->user()->id)
                    ->get();

        $total = 0;
        foreach($cart as $c){
            $total += $c->price * $c->quantity;
        }
        return view('user.cart',compact('cart','total'));
    }

    //direct history page
    public function history()
    {
        $cart = Cart::where('user_id',auth()->user()->id)->get();
        $order = Order::where('user_id',auth()->user()->id)->orderBy('status','asc')->paginate(6);
        return view('user.history',compact('cart','order'));
    }

    //change format
    private function updatedUserData($data)
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address']
        ];
    }
}
