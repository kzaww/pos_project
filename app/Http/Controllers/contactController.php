<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class contactController extends Controller
{
    //direct contact page
    public function list()
    {
        $data = Contact::get();
        return view('admin.account.contact',compact('data'));
    }

    //store contact
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            "email" => 'required|email|exists:users,email',
            "message" => 'required|max:1056'
        ]);
        if($validate->fails()){
            return response()->json([
                'errors' => $validate->errors()
            ]);
        }

        $data = User::where('email',$request->email)->first();
        Contact::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $request->message
        ]);
        return response()->json([
            'status' => 'success'
        ],200);
    }

    //search in contact
    public function search(Request $request)
    {
        $data = Contact::where('name','like','%'.$request->data.'%')
                    ->orwhere('email','like','%'.$request->data.'%')
                    ->get();

        $count = count($data);
        $contact = '';
        $i=1;
        foreach($data as $item){
            $contact .='
            <li class="mt-3">
                <span >'.$i.'</span>
                <span >'.$item->name.'</span>
                <span >'.$item->email.'</span>
                <span >'.$item->message.'</span>
            </li>
            ';
        }

        return response()->json([
            'data' => $contact,
            'count' => $count
        ],200);
    }
}
