<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seo;
use Illuminate\Support\Facades\Route;

class SeoController extends Controller
{
    public function index(){
        $seos = Seo::get();
        return view('admin.seo.index',compact('seos'));
    }

    public function create(){
        return view('admin.seo.add');
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'page_name' => 'required|string|max:255|unique:seos,page_name',
            'meta_title' => 'required|string|max:255',
            'meta_keywords' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
        ], [
            'page_name.unique' => 'This page name already has SEO details.',
        ]);
        

        Seo::create([
            'page_name' => $request->page_name,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('seo.index')->with('success', 'SEO created successfully!');
    }

    public function edit($id)
    {
        $seo = Seo::findOrFail($id);
        return view('admin.seo.edit', compact('seo'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'page_name' => 'required|string|max:255|unique:seos,page_name,' . $id,
            'meta_title' => 'required|string|max:255',
            'meta_keywords' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
        ]);
        
        $seo = Seo::findOrFail($id);

        $seo->page_name = $request->page_name;
        $seo->meta_title = $request->meta_title;
        $seo->meta_keywords = $request->meta_keywords;
        $seo->meta_description = $request->meta_description;
        $seo->save();

        return redirect()->route('seo.index')->with('success', 'SEO updated successfully!');
    }


    public function destroy($id)
    {
        $seo = Seo::find($id);
        $seo->delete();
    
        return redirect()->route('seo.index')->with('success', 'SEO deleted successfully.');
    }
}
