<?php

namespace App\Http\Controllers;

use App\ElectricVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Storage;
use DB;

class ElectricVehicleController extends Controller
{
    /**
     * Vehicle instance.
     *
     * @var mixed
     */
    public $model;

    /**
     * Create a new ElectricVehicle instance.
     *
     * @return void
     */
    public function __construct(ElectricVehicle $model)
    {
        $this->model = $model;
    }

    /**
     * Show electric vehicles list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        // $vehicles = $this->model->orderBy('make')->get(['id', 'name']);
        // return response()->json([
        //     'vehicles' => $vehicles
        // ]);
        $query = ElectricVehicle::query()->orderByDesc('id');
        if ($request->has('make')) {
            $query->where('make', str_replace('-', ' ', $request->input('make')))->first();
        }

        if ($request->has('type')) {
            $query->where('type', $request->input('type'))->first();
        }

        if ($request->has('excludeBySlug')) {
            $query->where('slug', "!=", $request->input('excludeBySlug'))->first();
        }

        $objects = $query->exclude(['description', 'youtube', 'range', 'speed', 'efficiency', 'chargeSpeed', 'created_at', 'updated_at', 'seats', 'segment', 'drive', 'battery'])
            ->paginate(18);

        return response()->json([
            'data' => $objects->items(),
            'current_page' => $objects->currentPage(),
            'last_page' => $objects->lastPage(),
        ]);
    }

    public function all(Request $request)
    {
        $query = ElectricVehicle::query()->orderByDesc('id');
        $objects = $query->select(['slug', 'updated_at'])->get();

        $allUrls = $objects->map(function ($obj) {
            return [
                'url' => 'https://evrevue.com/cars/' . str_replace(' ', '-', strtolower($obj->slug)),
                'updatedAt' => Carbon::parse($obj->updated_at)->format('Y-m-d'),
            ];
        });

        $makes = ElectricVehicle::select('make', DB::raw('count(*) as total'))
            ->groupBy('make')->orderByDesc('total')->get();

        $allMakes = $makes->map(function ($obj) {
            return [
                'url' => 'https://evrevue.com/cars/make/' . str_replace(' ', '-', strtolower($obj->make)),
                'updatedAt' => Carbon::now()->format('Y-m-d'),
            ];
        });

        $types = ElectricVehicle::select('type')
            ->where('type', '!=', null)
            ->groupBy('type')->get();

        $allTypes = $types->map(function ($obj) {
            return [
                'url' => 'https://evrevue.com/cars/type/' . str_replace(' ', '-', strtolower($obj->type)),
                'updatedAt' => Carbon::now()->format('Y-m-d'),
            ];
        });

        return response()->json(array_merge($allUrls->toArray(), $allMakes->toArray(), $allTypes->toArray()));
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