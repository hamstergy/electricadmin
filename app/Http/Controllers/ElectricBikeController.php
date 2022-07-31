<?php

namespace App\Http\Controllers;

use App\ElectricBike;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use DB;

class ElectricBikeController extends Controller
{
    /**
     * Bike instance.
     *
     * @var mixed
     */
    public $model;

    /**
     * Create a new ElectricBike instance.
     *
     * @return void
     */
    public function __construct(ElectricBike $model)
    {
        $this->model = $model;
    }

    /**
     * Show electric bikes list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bikes()
    {
        $bikes = $this->model->orderBy('make')->get(['id', 'name']);

        return response()->json([
            'bikes' => $bikes
        ]);
    }

    public function index() {
        $bikes = ElectricBike::all()->reverse();
        return view('bikes.index', compact('bikes'));
    }

    public function json() {
        $bikes = ElectricBike::all()->values();
        foreach ($bikes as $bike) {
            unset($bike->created_at);
            unset($bike->updated_at);
        }
        return response()->json($bikes);
    }
    public function jsonMakes() {
        $bikes = ElectricBike::select('make', DB::raw('count(*) as total'))
            ->groupBy('make')->orderByDesc('total')
            ->get();
//        $vehicles = $vehicles->values()->sortBy('make');
//        $vehicles = $vehicles->sortBy('make');
//        $vehicles = $vehicles->sortBy('make');
        $arr = $bikes->map(function ($bike) {
            return [
                'name' => $bike->make,
                'slug' => str_replace(' ', '-', strtolower($bike->make))
            ];
        });
//        foreach ($vehicles as $vehicle) {
//            unset($vehicle->created_at);
//            unset($vehicle->updated_at);
//            $vehicle->isConcept = ($vehicle->isConcept) ? TRUE : FALSE;
//        }
        return response()->json($arr);
    }
    public function show(ElectricBike $bike)
    {
        return view('bikes.show', compact('bike'));
    }

    public function save(Request $request) {
        $data = $request->all();
        $validated = $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'title' => 'required|string',
            'speed' => 'integer|nullable',
            'range' => 'integer|nullable',
            'description' => 'string|nullable',
            'youtube' => 'string|nullable',
            'price' => 'numeric|nullable',
            'battery' => 'integer|nullable',
            'motor' => 'integer|nullable',
            'gears' => 'string|nullable',
            'tire' => 'string|nullable',
            'type' => 'string|nullable',
            'weight' => 'integer|nullable',
            'folding' => 'boolean|nullable',
            'break_system' => 'string|nullable',
            'frame_type' => 'string|nullable',
            'url' => 'url|nullable',
            'amazon_id' => 'string|nullable',
            'review_rate' => 'numeric|nullable',
            'imageSlug' => 'string|nullable',
            'slug' => 'string'
        ]);
        if(isset($data['id'])) {
            $bike = ElectricBike::find($data['id']);
            $bike->update($validated);
        } else {
            $slug = ( empty($validated['slug']))
                ? Str::slug($data['make'].' '.$data['model'],'-')
                : $validated['slug'];
            $bike = ElectricBike::create([
                'make' => $validated['make'],
                'model' => $validated['model'],
                'title' => $validated['title'],
                'speed' => $validated['speed'],
                'range' => $validated['range'],
                'description' => $validated['description'],
                'youtube' => $validated['youtube'],
                'price' => $validated['price'],
                'battery' => $validated['battery'],
                'motor' => $validated['motor'],
                'gears' => $validated['gears'],
                'tire' => $validated['tire'],
                'type' => $validated['type'],
                'weight' => $validated['weight'],
                'folding' => $validated['folding'],
                'break_system' => $validated['break_system'],
                'frame_type' => $validated['frame_type'],
                'url' => $validated['url'],
                'amazon_id' => $validated['amazon_id'],
                'review_rate' => $validated['review_rate'],
                'imageSlug' => $validated['imageSlug'],
                'slug' => $slug
            ]);
        }
        return response()->json([$bike,201]);
    }
    public function edit(ElectricBike $bike)
    {
        return view('bikes.edit', compact('bike'));
    }

    public function destroy(ElectricBike $bike)
    {
        $bike->delete();
        return redirect(route('bikes.index'))->with('notification', '"' . $bike->make .' '.$bike->model.  '" deleted!');
    }
    public function create() {
        return view('bikes.create');
    }
}
