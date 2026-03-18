<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Yajra\DataTables\Facades\DataTables;


class CityController extends Controller
{
    public function create()
    {
        $countries = Location::where('location_type', 0)->where('status', 0)->get();
        $states = Location::where('location_type', 1)->where('status', 0)->get();
        return view('admin.location.city.add', compact('countries', 'states'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city_name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (Location::where('name', $value)->where('location_type', 2)->exists()) {
                        $fail('The city name has already been taken.');
                    }
                },
            ],
            'country_name' => 'required|exists:location,location_id,location_type,0',
            'state_name' => 'required|exists:location,location_id,location_type,1',
            'status' => 'required',
        ]);

        $city = new Location();
        $city->name = $validated['city_name'];
        $city->location_type = 2;
        $city->parent_id = $validated['state_name'];
        $city->status = $validated['status'];
        $city->is_visible = 0;
        $city->save();

        return redirect()->route('cities.index')->with('success', 'City created successfully!');
    }

    // public function index()
    // {
    //     $cities = Location::where('location_type', 2)->orderBy('name', 'asc')->get();
    //     return view('admin.location.city.index', compact('cities'));
    // }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cities = Location::where('location_type', 2)
                ->with(['parent' => function ($query) {
                    $query->with('parent');
                }])
                ->select('location_id', 'name', 'status', 'parent_id')
                ->orderBy('name', 'asc')
                ->get();

return DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('state', function ($row) {
                    return $row->parent ? $row->parent->name : '-';
                })
                ->addColumn('country', function ($row) {
                    return $row->parent && $row->parent->parent ? $row->parent->parent->name : '-';
                })
                ->addColumn('status', function ($row) {
                    return '<select class="form-select" onchange="changeStatus(this, \'location\')" data-id="' . $row->location_id . '">
                            <option value="0"' . ($row->status == 0 ? ' selected' : '') . '>Active</option>
                            <option value="1"' . ($row->status == 1 ? ' selected' : '') . '>Deactive</option>
                        </select>';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="d-flex">
                            <a href="' . route('cities.edit', $row->location_id) . '" class="btn-sm">
                                <i class="fa-regular fa-pen-to-square me-1"></i>
                            </a>
                            <a href="javascript:void(0);"
                               onclick="event.preventDefault();
                                        if(confirm(\'Are you sure you want to delete this city?\'))
                                            document.getElementById(\'delete-form-' . $row->location_id . '\').submit();"
                               class="" style="color: rgb(32, 2, 2);border: none">
                                 <i class="fa-solid fa-trash-can"></i>
                            </a>
                            <form id="delete-form-' . $row->location_id . '" action="' . route('cities.destroy', $row->location_id) . '" method="POST" style="display: none;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                            </form>
                        </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.location.city.index');
    }


    public function edit($id)
    {
        $city = Location::find($id);
        if (!$city || $city->location_type != 2) {
            return redirect()->route('city.index')->with('error', 'City not found');
        }

        $countries = Location::where('location_type', 0)->where('status', 0)->get();
        // dd($countries);
        $states = Location::where('location_type', 1)->where('status', 0)->get();

        return view('admin.location.city.edit', compact('city', 'countries', 'states'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'city_name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($id) {
                    if (Location::where('name', $value)
                        ->where('location_type', 2)
                        ->where('location_id', '!=', $id) // Exclude current city
                        ->exists()
                    ) {
                        $fail('The city name has already been taken.');
                    }
                },

            ],
            'country_name' => 'required|exists:location,location_id,location_type,0',
            'state_name' => 'required|exists:location,location_id,location_type,1',
            'status' => 'required',
        ]);

        $city = Location::find($id);
        if (!$city || $city->location_type != 2) {
            return redirect()->route('cities.index')->with('error', 'City not found');
        }

        $city->name = $validated['city_name'];
        $city->status = $validated['status'];
        $city->parent_id = $validated['state_name'];
        $city->save();

        return redirect()->route('cities.index')->with('success', 'City updated successfully!');
    }

    public function destroy($id)
    {
        $city = Location::find($id);

        if ($city && $city->location_type == 2) {

            $city->delete();

            return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
        }

        return redirect()->route('cities.index')->with('error', 'City not found or deletion failed.');
    }

    public function fetchStatesByCountry(Request $request)
    {
        $countryId = $request->input('country_id');
        if (!$countryId) {
            return response()->json(['states' => []]);
        }
        
        // Convert to integer for proper comparison
        $countryId = (int)$countryId;
        
        $states = Location::where('location_type', 1)
            ->where('parent_id', $countryId)
            ->where('status', 0)
            ->orderBy('name', 'asc')
            ->get();
        
        // Format response properly
        $formattedStates = $states->map(function($state) {
            return [
                'location_id' => (int)$state->location_id,
                'name' => $state->name
            ];
        });
        
        return response()->json(['states' => $formattedStates]);
    }

    public function fetchCitiesByState(Request $request)
    {
        $stateId = $request->input('state_id');
        if (!$stateId) {
            return response()->json(['cities' => []]);
        }
        
        // Convert to integer for proper comparison
        $stateId = (int)$stateId;
        
        $cities = Location::where('location_type', 2)
            ->where('parent_id', $stateId)
            ->where('status', 0)
            ->orderBy('name', 'asc')
            ->get();
        
        // Format response properly
        $formattedCities = $cities->map(function($city) {
            return [
                'location_id' => (int)$city->location_id,
                'name' => $city->name
            ];
        });
        
        return response()->json(['cities' => $formattedCities]);
    }
}
