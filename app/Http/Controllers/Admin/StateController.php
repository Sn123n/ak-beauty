<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Location;
use Yajra\DataTables\Facades\DataTables;

class StateController extends Controller
{
    public function create()
    {
        $countries = Location::where('location_type', 0)->where('status', 0)->get();
        return view('admin.location.state.add', compact('countries'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'state_name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (Location::where('name', $value)->where('location_type', 1)->exists()) {
                        $fail('The state name has already been taken.');
                    }
                },
            ],
            'country_name' => 'required|exists:location,location_id,location_type,0',
            'status' => 'required',
        ]);

        $state = new Location();
        $state->name = $validated['state_name'];
        $state->status = $validated['status'];
        $state->location_type = 1;
        $state->parent_id = $validated['country_name'];
        $state->is_visible = 0;
        $state->save();

        return redirect()->route('state.index')->with('success', 'State created successfully!');
    }

    // public function index(Request $request)
    // {
    //     $states = Location::where('location_type', 1)
    //         ->with('parent')->orderBy('name', 'asc')->get();


    //     return view('admin.location.state.index', compact('states'));
    // }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $states = Location::where('location_type', 1)
                ->with('parent') // parent is the country here
                ->select('location_id', 'name', 'status', 'parent_id')
                ->orderBy('name', 'asc')
                ->get();

            return DataTables::of($states)
                ->addIndexColumn()
                ->addColumn('country', function ($row) {
                    return $row->parent ? $row->parent->name : '-';
                })
                ->addColumn('status', function ($row) {
                    return '<select class="form-select" onchange="changeStatus(this, \'location\')" data-id="' . $row->location_id . '">
                                <option value="0"' . ($row->status == 0 ? ' selected' : '') . '>Active</option>
                                <option value="1"' . ($row->status == 1 ? ' selected' : '') . '>Deactive</option>
                            </select>';
                })

                ->addColumn('action', function ($row) {
                    return '<div class="d-flex">
                            <a href="' . route('state.edit', $row->location_id) . '" class="btn-sm">
                                <i class="fa-regular fa-pen-to-square me-1"></i>
                            </a>
                            <a href="javascript:void(0);" 
                               onclick="event.preventDefault(); 
                                        if(confirm(\'Are you sure you want to delete this state?\')) 
                                            document.getElementById(\'delete-form-' . $row->location_id . '\').submit();" 
                               class="" style="color: rgb(32, 2, 2);border: none">
                                 <i class="fa-solid fa-trash-can"></i>
                            </a>
                            <form id="delete-form-' . $row->location_id . '" action="' . route('state.destroy', $row->location_id) . '" method="POST" style="display: none;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                            </form>
                        </div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.location.state.index');
    }

    public function edit($id)
    {
        $state = Location::find($id);
        if (!$state || $state->location_type != 1) {
            return redirect()->route('state.index')->with('error', 'State not found');
        }

        $countries = Location::where('location_type', 0)->where('status', 0)->get();
        return view('admin.location.state.edit', compact('state', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'state_name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($id) {
                    if (Location::where('name', $value)->where('location_type', 1)->where('location_id', '!=', $id)->exists()) {
                        $fail('The state name has already been taken.');
                    }
                },
            ],
            'country_name' => 'required|exists:location,location_id,location_type,0',
            'status' => 'required',
        ]);

        $state = Location::find($id);
        if (!$state || $state->location_type != 1) {
            return redirect()->route('state.index')->with('error', 'State not found');
        }

        $state->name = $validated['state_name'];
        $state->status = $validated['status'];
        $state->parent_id = $validated['country_name'];
        $state->save();

        return redirect()->route('state.index')->with('success', 'State updated successfully!');
    }

    public function destroy($id)
    {
        $state = Location::find($id);

        if ($state) {
            Location::where('parent_id', $id)->delete();

            $state->delete();

            return redirect()->route('state.index')->with('success', 'State and related cities deleted successfully.');
        }

        return redirect()->route('state.index')->with('error', 'State not found or deletion failed.');
    }
}
