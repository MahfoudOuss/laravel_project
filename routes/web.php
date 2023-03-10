<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//common Resource Routes:
    //  index show create{diplay form to create} store edit{diplay form to edit} update destroy
Route::get('/',[ListingController::class,'index']);

Route::get('/listings/create',[ListingController::class,'create'])->middleware('auth');

Route::post('/listings',[ListingController::class,'store'])->middleware('auth');
// show Edit form
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');

Route::delete('/listings/{listing}',[ListingController::class,'delete'])->middleware('auth');

Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');

Route::get('/listings/{listing}',[ListingController::class,'show']);

Route::get('/users/register',[UserController::class,'create'])->middleware('guest');

Route::post('/users',[UserController::class,'store']);

Route::post('/users/logout',[UserController::class,'logout'])->middleware('auth');

Route::get('/users/login',[UserController::class,'login'])->name('login');

Route::post('/users/auth',[UserController::class,'auth']);






















































    // $listing = Listing::find($id);
    // model binding 
    // if($listing){
    //     return view('listing',[
    //     'listing' =>$listing]);

    // }else{
    //     abort('404');
    // }





// Route::get('/home', function () {
//     return response('<h1>home page</h1>')
//     ->header('Content-Type','text/plain')
//     ;
// });
// Route::get('/home/{id}', function ($id) {
//     return response('<h1>home page '.$id.'</h1>')
//     ->header('Content-Type','text/html')
//     ;
// })->where('id','[0-9]+');
// Route::get('/search',function(Request $request){
//     return response('this is the request :'.$request->name.' the second request '.$request->age)
//     ->header('Content-Type','text/plain');
// });