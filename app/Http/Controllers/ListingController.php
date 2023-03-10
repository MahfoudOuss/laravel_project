<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{   //show all listings
    public function index(){
        return view('listings/index',[
            'listings' =>Listing::latest()->filter(request(['search','tag']))->paginate(4)
        ]);
    }
    //show single listing
    public function show(Listing $listing){
        return view('listings.show',[
            'listing'=>$listing]);
    }
    //show form for creating
    public function create(){
        return view('listings/create');
    }
    //Store Listing data
    public function store(Request $request){
        
        $formfields = $request->validate(
            [
                'title' =>'required|string',
                'company' =>['required',Rule::unique('listings','company')],
                'location' =>'required',
                'email' =>'required|string|email',
                'website' =>'required|string',
                'tags' =>'required|string',
                'description' =>'required|string',
            ]
            );
        if($request->hasFile('logo')){
            $formfields['logo']=$request->file('logo')->store('logos','public');
        }
        //insert the user id to the Listing table
        $formfields['user_id']=auth()->id();
       

        Listing::create($formfields);
        return redirect('/')->with('message','Listing created succesfully');
            
    }
    public function edit(Listing $listing){
        return view('listings/edit',[
            'listing'=>$listing]);
    }
    public function update(Request $request,Listing $listing){
        //make sure theuser isthe owner 
        if ($listing->user_id != auth()->id) {
            abort(403,'Unauthorized action');
        }
        $formfields = $request->validate(
            [
                'title' =>'required|string',
                'company' =>['required'],
                'location' =>'required',
                'email' =>'required|string|email',
                'website' =>'required|string',
                'tags' =>'required|string',
                'description' =>'required|string',
            ]
            );
        if($request->hasFile('logo')){
            $formfields['logo']=$request->file('logo')->store('logos','public');
        }
       

        $listing->update($formfields);
        return back()->with('message','Listing updated  succesfully');
            
    }
    public function delete(Listing $listing){
        if ($listing->user_id != auth()->id) {
            abort(403,'Unauthorized action');
        }
        $listing->delete();
        return redirect('/')->with('message','Listing deleted successfully');
    }
    public function manage(){
        return view('/listings/manage',['listings' => auth()->user()->listings]);
    }
}
