<?php

namespace App\Http\Controllers;

use App\ElectricVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use DB;

class UsedCarController extends Controller
{
    /**
     * Carfax Root API URL
     * @type string
     * @access private
     */
    private $apiUrl = 'https://helix.carfax.com/search/v2/';

    /**
     * Show used electric cars list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $current_page = 1;
        if ($request->has('page')) {
            $current_page = (int) $request->page;
        }

        // https://helix.carfax.com/search/v2/vehicles?radius=3000&sort=LISTING_DATE_DESC&vehicleCondition=USED&specialtyLock=s8&engines=Electric&valueBadges=GREAT&mileageMax=30000&yearMin=2020&page=50&dynamicRadius=false&urlInfo=Used-Electric-Cars_s8

        // $response = Http::get('https://helix.carfax.com/search/v2/vehicles?radius=3000&sort=LISTING_DATE_DESC&vehicleCondition=USED&specialtyLock=s8&engines=Electric&valueBadges=GREAT&mileageMax=30000&yearMin=2020&page=50&dynamicRadius=false&urlInfo=Used-Electric-Cars_s8');
        $response = Http::get(
            'https://helix.carfax.com/search/v2/vehicles',
            [
                'radius' => 3000,
                'sort' => 'LISTING_DATE_DESC',
                'vehicleCondition' => 'USED',
                'noAccidents' => 'TRUE',
                'personalUse' => 'TRUE',
                'serviceRecords' => 'TRUE',
                'engines' => 'Electric',
                'valueBadges' => 'GREAT',
                'dynamicRadius' => 'false',
                'zip' => 92683,
                'mileageMax' => 30000,
                'yearMin' => 2021,
                'make' => 'audi',
                'model' => 'Q4 e-tron',
                'page' => $current_page,
            ]
        );

        return response()->json([
            // 'data' => $response->object()->listings,
            'allData' => $response->object(),
            'currentPage' => $current_page,
            'lastPage' => $response->object()->totalPageCount,
        ]);
    }

    public function all(Request $request)
    {
        // $vehicles = $this->model->orderBy('make')->get(['id', 'name']);
        // return response()->json([
        //     'vehicles' => $vehicles
        // ]);
        $query = ElectricVehicle::query()->orderByDesc('id');

        $objects = $query->select(['slug'])->get();

        return response()->json($objects);
    }

    public function singleCar(ElectricVehicle $electric, $slug)
    {
        return response()->json(ElectricVehicle::where('slug', $slug)->first());
    }

    public function index()
    {
        $vehicles = ElectricVehicle::all()->reverse();
        return view('electric.index', compact('vehicles'));
    }

    public function json()
    {
        $vehicles = ElectricVehicle::all()->reverse()->values();
        foreach ($vehicles as $vehicle) {
            unset($vehicle->created_at);
            unset($vehicle->updated_at);
            $vehicle->isConcept = ($vehicle->isConcept) ? TRUE : FALSE;
            $vehicle->slug = str_replace(' ', '-', strtolower($vehicle->slug));
        }
        return response()->json($vehicles);
    }

    public function jsonMakes(Request $request)
    {

        $vehicles = ElectricVehicle::select('make', DB::raw('count(*) as total'))
            ->groupBy('make')->orderByDesc('total');

        if ($request->has('make')) {
            $vehicles->where('make', str_replace('-', ' ', $request->input('make')))->first();
        }

        $vehicles = $vehicles->get();
        $arr = $vehicles->map(function ($vehicle) {
            return [
                'name' => $vehicle->make,
                'slug' => str_replace(' ', '-', strtolower($vehicle->make))
            ];
        });
        return response()->json($arr);
    }

    public function show(ElectricVehicle $electric)
    {
        return view('electric.show', compact('electric'));
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $validated = $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'isConcept' => 'boolean',
            'releaseDate' => 'string|nullable',
            'acceleration' => 'numeric|nullable',
            'speed' => 'integer|nullable',
            'range' => 'integer|nullable',
            'efficiency' => 'integer|nullable',
            'chargeSpeed' => 'integer|nullable',
            'battery' => 'integer|nullable',
            'price' => 'integer|nullable',
            'drive' => 'string|nullable',
            'type' => 'string|nullable',
            'segment' => 'string|nullable',
            'seats' => 'integer|nullable',
            'description' => 'string|nullable',
            'imageSlug' => 'string|nullable',
            'youtube' => 'string|nullable',
            'slug' => 'string'
        ]);
        if (isset($data['id'])) {
            $vehicle = ElectricVehicle::find($data['id']);
            $vehicle->update($validated);
        } else {
            $slug = (empty($validated['slug']))
                ? Str::slug($data['make'] . ' ' . $data['model'], '-')
                : $validated['slug'];
            $vehicle = ElectricVehicle::create([
                'make' => $validated['make'],
                'model' => $validated['model'],
                'isConcept' => $validated['isConcept'],
                'releaseDate' => $validated['releaseDate'],
                'acceleration' => $validated['acceleration'],
                'speed' => $validated['speed'],
                'range' => $validated['range'],
                'efficiency' => $validated['efficiency'],
                'chargeSpeed' => $validated['chargeSpeed'],
                'battery' => $validated['battery'],
                'price' => $validated['price'],
                'drive' => $validated['drive'],
                'type' => $validated['type'],
                'segment' => $validated['segment'],
                'seats' => $validated['seats'],
                'description' => $validated['description'],
                'imageSlug' => $validated['imageSlug'],
                'youtube' => $validated['youtube'],
                'slug' => $slug
            ]);
        }
        return response()->json([$vehicle, 201]);
    }
    public function edit(ElectricVehicle $electric)
    {
        //        return $vehicle;
        return view('electric.edit', compact('electric'));
    }

    public function destroy(ElectricVehicle $electric)
    {
        $electric->delete();
        return redirect(route('electric.index'))->with('notification', '"' . $electric->make . ' ' . $electric->model . '" deleted!');
    }
    public function create()
    {
        return view('electric.create');
    }
}