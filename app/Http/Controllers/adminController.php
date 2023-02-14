<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    //direct account detail page
    public function detail()
    {
        return view('admin.account.detail');
    }

    //update user data
    public function change(Request $request)
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

    //change password
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

    //image Upload
    public function imageUpdate(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'image' => 'required|mimes:png,jpg,jpeg|file',
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

    //direct adminList Page
    public function adminList()
    {
        $data = User::when(request('key'),function($query){
                    $query->orwhere('name','like','%'.request('key').'%')
                          ->orWhere('email','like','%'.request('key').'%')
                          ->orWhere('address','like','%'.request('key').'%');
        })
                    ->where('role','admin')->paginate(3);
        return view('admin.account.list',compact('data'));
    }

    //direct user list
    public function userList()
    {
        $data = User::when(request('key'),function($query){
                $query->orwhere('name','like','%'.request('key').'%')
                    ->orWhere('email','like','%'.request('key').'%')
                    ->orWhere('address','like','%'.request('key').'%');
        })
                    ->where('role','user')->paginate(3);
        return view('admin.account.userList',compact('data'));
    }

    //delete acc
    public function adminDelete(Request $request)
    {
        $data = User::where('id',$request->id)->first();
        $dbImage = $data->image;
        if(File::exists(public_path('admin/userImage/'.$dbImage))){
            File::delete(public_path('admin/userImage/'.$dbImage));
        }
        User::where('id',$request->id)->delete();
        return back()->with('deleteSuccess','Successfullly deleted!!');
    }

    //change role
    public function changeRole(Request $request)
    {
        User::where('id',$request->id)->update(['role' => $request->role]);
        return back()->with('roleSuccess','Change Role Success');
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
