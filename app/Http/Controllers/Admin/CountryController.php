<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    public function create()
    {
        return view('admin.location.country.add');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (Location::where('name', $value)->where('location_type', 0)->exists()) {
                        $fail('The country name has already been taken.');
                    }
                },
            ],
            'status' => 'required',
        ]);


        $country = new Location();
        $country->name = $validated['name'];
        $country->status = $validated['status'];
        $country->location_type = 0;
        $country->parent_id = 0;
        $country->is_visible = 0;
        $country->save();

        return redirect()->route('countries.index')->with('success', 'Country created successfully!');
    }

    // public function index()
    // {
    //     $countrys = Location::where('location_type', 0)->orderBy('name', 'asc')->get();
    //     return view('admin.location.country.index', compact('countrys'));
    // }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countrys = Location::where('location_type', 0)
                ->select('location_id', 'name')
                ->orderBy('name', 'asc')
                ->get();

            return DataTables::of($countrys)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return '<select class="form-select" onchange="changeStatus(this, \'location\')" data-id="' . $row->location_id . '">
                                <option value="0"' . ($row->status == 0 ? ' selected' : '') . '>Active</option>
                                <option value="1"' . ($row->status == 1 ? ' selected' : '') . '>Deactive</option>
                            </select>';
                })

                ->addColumn('action', function ($row) {
                    return '<div class="d-flex">
                                <a href="' . route('countries.edit', $row->location_id) . '" class="btn-sm">
                                    <i class="fa-regular fa-pen-to-square me-1"></i>
                                </a>
                                <a href="javascript:void(0);" 
                                   onclick="event.preventDefault(); 
                                            if(confirm(\'Are you sure you want to delete this country?\')) 
                                                document.getElementById(\'delete-form-' . $row->location_id . '\').submit();" 
                                   class="" style="color: rgb(32, 2, 2);border: none">
                                     <i class="fa-solid fa-trash-can"></i>
                                </a>
                                <form id="delete-form-' . $row->location_id . '" action="' . route('countries.destroy', $row->location_id) . '" method="POST" style="display: none;">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                </form>
                            </div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.location.country.index');
    }

    public function edit($id)
    {
        $country = Location::find($id);
        if (!$country || $country->location_type != 0) {
            return redirect()->route('countries.index')->with('error', 'Country not found');
        }

        return view('admin.location.country.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($id) {
                    if (Location::where('name', $value)->where('location_type', 0)->where('location_id', '!=', $id)->exists()) {
                        $fail('The country name has already been taken.');
                    }
                },
            ],
            'status' => 'required',
        ]);


        $country = Location::find($id);
        if (!$country || $country->location_type != 0) {
            return redirect()->route('countries.index')->with('error', 'Country not found');
        }

        $country->name = $validated['name'];
        $country->status = $validated['status'];
        $country->save();

        return redirect()->route('countries.index')->with('success', 'Country updated successfully!');
    }

    public function destroy($id)
    {
        $deleted = Location::deleteCountry($id);

        if ($deleted) {
            return redirect()->route('countries.index')->with('success', 'Country and its related states and cities deleted successfully!');
        } else {
            return redirect()->route('countries.index')->with('error', 'Country not found or deletion failed!');
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            // Ensure location_id is being used correctly
            $location = Location::where('location_id', $request->id)->firstOrFail();
            $location->status = $request->status;
            $location->save();

            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating status', 'error' => $e->getMessage()], 500);
        }
    }
}
