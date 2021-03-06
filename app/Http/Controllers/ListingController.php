<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Get all listings
    public function index(){
        
        return view('listings.index', [        
            //We define how many listings we want to display per page
        'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
    ]);

    }
    // Get single listing
    public function show(Listing $listing){
    return view('listings.show', [
        'listing' => $listing
    ]);
    }

    // Show create form
    public function create(){
        return view('listings.create');
    }

    // Store listing data in database
    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
           $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        
        return redirect('/')->with('success', 'Listing created successfully');
    }

    // Show edit form
    public function edit(Listing $listing){
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    //Edit submit form
    public function update(Request $request, Listing $listing){
        // check if user is authorized to edit this listing
        if($listing->user_id !== auth()->id()){
           abort(403, 'You are not authorized to edit this item');
        }


        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
           $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);
        
        return back()->with('success', 'Listing updated successfully');
    }

    // Delete listing
    public function destroy(Listing $listing){
        // check if user is authorized to edit this listing
        if($listing->user_id !== auth()->id()){
           abort(403, 'You are not authorized to delete this item');
        }

        $listing->delete();
        return redirect('/')->with('success', 'Listing deleted successfully');
    }

    // Manage listings page
    public function manage(){
        return view('listings.manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
