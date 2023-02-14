<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class categoryController extends Controller
{
    //direct category list
    public function categoryList()
    {
        $data = Category::when(request('key'),function($query){
            $query->where('category_name','like','%'.request('key').'%');
        })
                        ->orderBy('updated_at','DESC')->paginate(5);

        if(count($data) == 0 )
        {
            $status = false;
        }else{
            $status = true;
        }
        return view('admin.category.categoryList')->with(['data'=>$data,'status'=>$status]);
    }

    //direct category create
    public function categoryCreate()
    {
        return view('admin.category.categoryCreate');
    }

    //create category
    public function create(Request $request)
    {
        Validator::make($request->all(),[
            'name' => 'required|unique:categories,category_name',
        ])->validate();

        $data = $this->requestcategorydata($request);
        Category::create($data);
        return redirect()->route('admin#categoryList')->with('createSuccess','Successfully Created');
    }

    //direct edit page
    public function edit($id)
    {
        $data = Category::where('category_id',$id)->first();
        return view('admin.category.categoryEdit',compact('data'));
    }

    //update category data
    public function update(Request $request)
    {
        Validator::make($request->all(),[
            'name' => "required|unique:categories,category_name,$request->id,category_id",
        ])->validate();
        $data = $this->requestcategorydata($request->all());
        Category::where('category_id',$request->id)->update($data);
        return redirect()->route('admin#categoryList')->with('updateSuccess','Successfully Updated');
    }

    //delete Category
    public function delete(Request $request)
    {
        $id = $request->id;
        Category::where('category_id',$id)->delete();
        return back()->with('deleteSuccess','Successfully Deleted!');
    }


    //category data change formate
    private function requestcategorydata($data)
    {
        return [
            'category_name' => $data['name']
        ];
    }
}
