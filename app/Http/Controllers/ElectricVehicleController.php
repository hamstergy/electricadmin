<?php

namespace App\Http\Controllers;

use App\ElectricVehicle;
use Illuminate\Http\Request;
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
    public function vehicles()
    {
        $vehicles = $this->model->orderBy('make')->get(['id', 'name']);

        return response()->json([
            'vehicles' => $vehicles
        ]);
    }

    public function index() {
        $vehicles = ElectricVehicle::all()->reverse();
        return view('electric.index', compact('vehicles'));
    }

    public function json() {
        $vehicles = ElectricVehicle::all()->reverse()->values();
        foreach ($vehicles as $vehicle) {
            unset($vehicle->created_at);
            unset($vehicle->updated_at);
            $vehicle->isConcept = ($vehicle->isConcept) ? TRUE : FALSE;
        }
        return response()->json($vehicles);
    }
    public function jsonMakes() {
        $vehicles = ElectricVehicle::select('make', DB::raw('count(*) as total'))
            ->groupBy('make')->orderByDesc('total')
            ->get();
//        $vehicles = $vehicles->values()->sortBy('make');
//        $vehicles = $vehicles->sortBy('make');
//        $vehicles = $vehicles->sortBy('make');
        $arr = $vehicles->map(function ($vehicle) {
            return [
                'name' => $vehicle->make,
                'slug' => str_replace(' ', '-', strtolower($vehicle->make))
            ];
        });
//        foreach ($vehicles as $vehicle) {
//            unset($vehicle->created_at);
//            unset($vehicle->updated_at);
//            $vehicle->isConcept = ($vehicle->isConcept) ? TRUE : FALSE;
//        }
        return response()->json($arr);
    }
    public function show(ElectricVehicle $electric)
    {
        return view('electric.show', compact('electric'));
    }

    public function save(Request $request) {
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
        if(isset($data['id'])) {
            $vehicle = ElectricVehicle::find($data['id']);
            $vehicle->update($validated);
        } else {
            $slug = ( empty($validated['slug']))
                ? Str::slug($data['make'].' '.$data['model'],'-')
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
        return response()->json([$vehicle,201]);
    }
    public function edit(ElectricVehicle $electric)
    {
//        return $vehicle;
        return view('electric.edit', compact('electric'));
    }

    public function destroy(ElectricVehicle $electric)
    {
        $electric->delete();
        return redirect(route('electric.index'))->with('notification', '"' . $electric->make .' '.$electric->model.  '" deleted!');
    }
    public function create() {
        return view('electric.create');
    }
}
