<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class productController extends Controller
{
    //direct product list page
    public function list()
    {
        $data = Product::when(request('key'),function($query){
                            $query->where('product_name','like','%'.request('key').'%');
                        })
                        ->LeftJoin('categories','categories.category_id','products.category_id')
                        ->OrderBy('products.view_count','desc')
                        ->paginate(3);
        if(count($data) == 0 ){
            $status = false;
        }else{
            $status = true;
        }
        return view('admin.product.list')->with(['data'=>$data,'status'=>$status]);
    }

    //direct product create page
    public function create()
    {
        $data = Category::get();

        return view('admin.product.create',compact('data'));
    }

    //insert product data
    public function insert(Request $request)
    {
        $this->dataValidation($request->all(),'create')->validate();

        $data = $this->insertDataFormat($request->all());


        if($request->file('image')){
            $file = $request->file('image');
            $imageName = uniqid().'_'.$file->getClientOriginalName();
            $data['product_image'] = $imageName;
            // dd($data);
            Product::create($data);
            $file->storeAs('public',$imageName);
            return redirect()->route('admin#productList')->with('createSuccess','Successfully created!');
        }

        return back()->with('fail','Oops,Something is wrong Try Again!!');
    }

    //delete product
    public function delete(Request $request)
    {
        $id = $request->id;
        $data = Product::where('product_id',$id)->first();
        $image = $data->product_image;

        if(Storage::exists('public/'.$image))
        {
            Storage::delete('public/'.$image);
            Product::where('product_id',$id)->delete();
        }else{
            Product::where('product_id',$id)->delete();
        }

        return back()->with('deleteSuccess','Successfully Deleted!!');
    }

    //direct edit page
    public function edit($id)
    {
        $data = Product::where('product_id',$id)->first();
        $category = Category::get();
        return view('admin.product.edit')->with(['data'=>$data,'category'=>$category]);
    }

    //update Product
    public function update(Request $request)
    {
        $validator = $this->dataValidation($request->all(),'update');
        if($validator->fails()){
            return back()->with('updateFail','Oops,Something is Wrong,Try Again!!')
                        ->withErrors($validator)
                        ->withInput();
        };
        $id = $request->id;
        $data = $this->upateDataInfo($request->all());
        if($request->file('image'))
        {
            $dbImage = Product::where('product_id',$id)->first();
            $dbImage = $dbImage->product_image;
            $file = $request->file('image');
            $imageName = uniqid().'_'.$file->getClientOriginalName();

            $data['product_image'] = $imageName;
            if(File::exists(public_path('storage/'.$dbImage))){
                Storage::delete('public/'.$dbImage);
            }
            $file->storeAs('public',$imageName);
            Product::where('product_id',$id)->update($data);
        }else{
            Product::where('product_id',$id)->update($data);
        }
        return redirect()->route('admin#productList')->with('updateSuccess','Successfully Updated!');
    }

    //direct detail page
    public function details($id){
        $data = Product::LeftJoin('categories','categories.category_id','products.category_id')
                        ->where('product_id',$id)->first();

        return view('admin.product.detail',compact('data'));
    }

    //change data format
    private function insertDataFormat($data)
    {
        return [
            'product_name' => $data['name'],
            'category_id' => $data['category'],
            'description' => $data['description'],
            'product_price' => $data['price'],
            'waiting_time' => $data['time']
        ];
    }

    //validate product
    private function dataValidation($data,$action)
    {
        if(isset($data['id'])){
            $id = $data['id'];
        }
        $validationRule = [
            'category' => 'required',
            'description' => 'required',
            'price' => 'required',
            'time' => 'required'
        ];

        $validationRule['name'] = $action == 'create' ? 'required|unique:products,product_name' : "required|unique:products,product_name,$id,product_id";
        $validationRule['image'] = $action == 'create' ? 'required|mimes:png,jpg,jpeg,webp|file' : 'mimes:png,jpg,jpeg,webp|file';

        return Validator::make($data,$validationRule);
    }

    private function upateDataInfo($data)
    {
        return [
            'product_name' => $data['name'],
            'category_id' => $data['category'],
            'description' => $data['description'],
            'product_price' => $data['price'],
            'waiting_time' => $data['time']
        ];
    }
}
