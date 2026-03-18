<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pincode;
use Yajra\DataTables\Facades\DataTables;

class PincodeController extends Controller
{
    public function create()
    {
        return view('admin.pincode.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pincode' => 'required|numeric|digits:6|unique:pincode,pincode',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $pincode = new Pincode();
        $pincode->pincode = $validated['pincode'] ?? null;
        $pincode->city = $validated['city'];
        $pincode->state = $validated['state'];
        $pincode->price = $validated['price'];
        $pincode->save();

        return redirect()->route('pincode.index')->with('success', 'Pincode created successfully!');
    }



    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pincodes = Pincode::select('id', 'pincode', 'city', 'state', 'price')
                ->orderBy('created_at', 'desc') 
                ->get();
            // dd($pincodes);
            return DataTables::of($pincodes)
                ->addIndexColumn() 
                ->addColumn('action', function ($row) {
                    return '<div class="d-flex">
                                <a href="' . route('pincode.edit', $row->id) . '" class="btn-sm">
                                    <i class="fa-regular fa-pen-to-square me-1"></i>
                                </a>
                                <a href="javascript:void(0);" 
                                   onclick="event.preventDefault(); 
                                            if(confirm(\'Are you sure you want to delete this pincode?\')) 
                                                document.getElementById(\'delete-form-' . $row->id . '\').submit();" 
                                   class="" style="color: rgb(32, 2, 2);border: none">
                                     <i class="fa-solid fa-trash-can"></i>
                                </a>
                                <form id="delete-form-' . $row->id . '" action="' . route('pincode.destroy', $row->id) . '" method="POST" style="display: none;">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                </form>
                            </div>';
                })
                ->rawColumns(['action'])  
                ->make(true);  
        }

        return view('admin.pincode.index');
    }



    public function edit($id)
    {
        $pincode = Pincode::find($id);
        if (!$pincode) {
            return redirect()->route('admin.pincode.index')->with('error', 'Pincode not found');
        }

        return view('admin.pincode.add', compact('pincode'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pincode' => 'required|numeric|digits:6',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $pincode = Pincode::find($id);
        if (!$pincode) {
            return redirect()->route('pincode_index')->with('error', 'Pincode not found');
        }

        $pincode->pincode = $validated['pincode'];
        $pincode->city = $validated['city'];
        $pincode->state = $validated['state'];
        $pincode->price = $validated['price'];
        $pincode->save();

        return redirect()->route('pincode.index')->with('success', 'Pincode updated successfully');
    }

    public function destroy($id)
    {
        $pincode = Pincode::find($id);
        if (!$pincode) {
            return redirect()->route('pincode_index')->with('error', 'Pincode not found');
        }

        $pincode->delete();
        return redirect()->route('pincode.index')->with('success', 'Pincode deleted successfully');
    }
}
