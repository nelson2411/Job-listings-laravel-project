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
}
