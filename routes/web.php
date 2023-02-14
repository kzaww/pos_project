<?php

use App\Http\Middleware\userCheck;
use App\Http\Middleware\adminCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ajaxController;
use App\Http\Controllers\authentication;
use App\Http\Controllers\userController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\chartController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\productController;
use App\Http\Controllers\categoryController;



//login page
route::middleware('adminCheck')->group(function(){
    Route::redirect('/','loginPage');
    route::get('loginPage',[authentication::class,'loginpage'])->name('admin#login');

    route::get('registerPage',[authentication::class,'registerPage'])->name('admin#register');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {

    //dashboard(guide user page and admin page)
    route::get('/dashboard',[authentication::class,'dashboard'])->name('admin#dashboard');

    route::middleware([adminCheck::class])->group(function(){

        //chart
        route::get('chart',[chartController::class,'list'])->name('admin#chartList');

        //category prefix
        route::prefix('category')->group(function(){
            //direct category page
            route::get('list',[categoryController::class,'categoryList'])->name('admin#categoryList');
            //direct category create page
            route::get('create',[categoryController::class,'categoryCreate'])->name('admin#categoryCreate');
            route::post('create',[categoryController::class,'create'])->name('admin#createCategory');
            route::post('delete',[categoryController::class,'delete'])->name('admin#categoryDelete');
            route::get('edit/{id}',[categoryController::class,'edit'])->name('admin#categoryEdit');
            route::post('update',[categoryController::class,'update'])->name('admin#categoryUpdate');
        });

        //account prefix
        route::prefix('account')->group(function(){
            //direct account detail page
            route::get('profile',[adminController::class,'detail'])->name('admin#accountDetail');
            //change profile(still need profile photo)
            route::post('changeProfile',[adminController::class,'change'])->name('admin#changeProfile');
            //change password
            route::post('changePassword',[adminController::class,'changePassword'])->name('admin#changePassword');
            route::post('imageUpdate',[adminController::class,'imageUpdate'])->name('admin#userImageUpdate');
            //Admin List
            route::get('adminList',[adminController::class,'adminList'])->name('admin#adminList');
            route::post('delete',[adminController::class,'adminDelete'])->name('admin#adminDelete');
            route::post('changeRole',[adminController::class,'changeRole'])->name('admin#changRole');
            //user List
            route::get('userList',[adminController::class,'userList'])->name('admin#userList');
        });

        //product prefix
        route::prefix('product')->group(function(){
            //direct product list page
            route::get('list',[productController::class,'list'])->name('admin#productList');
            route::get('create',[productController::class,'create'])->name('admin#productCreate');
            route::post('insert',[productController::class,'insert'])->name('admin#productInsert');
            route::post('delete',[productController::class,'delete'])->name('admin#productDelete');
            route::get('edit/{id}',[productController::class,'edit'])->name('admin#productEdit');
            route::post('update',[productController::class,'update'])->name('admin#productUpdate');
            route::get('details/{id}',[productController::class,'details'])->name('admin#productDetail');
        });

        //order prefix
        route::prefix('order')->group(function(){
            route::get('list',[orderController::class,'list'])->name('admin#orderList');
            route::get('listSearch/{order_code}',[orderController::class,'listDetails'])->name('admin#orderDetails');
            route::get('ajax/list',[orderController::class,'ajaxList']);
            route::get('ajax/Totalsearch',[orderController::class,'ajaxTotalSearch'])->name('admin#orderTotalSearch');
            route::get('ajax/Datasearch',[orderController::class,'ajaxDataSearch'])->name('admin#orderSearch');
            route::get('pagination_list',[orderController::class,'pagination']);
        });

        route::prefix('contact')->group(function(){
            route::get('list',[contactController::class,'list'])->name('admin#contact');
            route::get('ajax/search',[contactController::class,'search'])->name('admin#contactSearch');
        });
    });





    route::group(['prefix'=>'user','middleware'=>userCheck::class],function(){
        //direct user page
        route::get('home',[userController::class,'user'])->name('user#home');
        route::get('account',[userController::class,'account'])->name('user#account');
        route::post('changeProfile',[userController::class,'changeProfile'])->name('user#changeProfile');
        route::post('uploadImage',[userController::class,'uploadImage'])->name('user#uploadImage');
        route::post('changePassword',[userController::class,'changePassword'])->name('user#changePassword');

        //detail page
        route::get('details/{id}',[userController::class,'details'])->name('user#details');

        route::get('cart',[userController::class,'cart'])->name('user#cart');

        route::get('history',[userController::class,'history'])->name('user#history');

        route::prefix('ajax')->group(function(){
            //sort and filter
            route::get('pizza/list',[ajaxController::class,'list']);
            route::get('filter/category',[ajaxController::class,'category']);
            route::get('filter/price',[ajaxController::class,'price']);
            //cart
            route::get('cart',[ajaxController::class,'cart']);
            route::get('clearCart',[ajaxController::class,'clearCart']);
            route::get('clear/cart',[ajaxController::class,'clearSingle']);
            //order
            route::get('orderList',[ajaxController::class,'orderList']);
            //view count
            route::get('viewCount',[ajaxController::class,'viewCount'])->name('viewCount');
            //contact
            route::post('storeContact',[contactController::class,'store'])->name('contact');
        });
    });


});
