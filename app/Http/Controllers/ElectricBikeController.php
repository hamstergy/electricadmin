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

    /**
     * Show electric bikes list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $query = ElectricBike::query()->where('active', '!=', 0)->orderByDesc('active');

        if ($request->has('make')) {
            $query->where('make', str_replace('-', ' ', $request->input('make')))->orWhere('make', $request->input('make'));
        }

        if ($request->has('type')) {
            $query->where('type', $request->input('type'))->first();
        }

        if ($request->has('priceFrom')) {
            $query->where('price', '>=', $request->input('priceFrom'))->first();
        }

        if ($request->has('priceTo')) {
            $query->where('price', '<=', $request->input('priceTo'))->first();
        }

        if ($request->has('excludeBySlug')) {
            $query->where('slug', "!=", $request->input('excludeBySlug'))->first();
        }

        $objects = $query->paginate(20);

        return response()->json([
            'data' => $objects->items(),
            'current_page' => $objects->currentPage(),
            'last_page' => $objects->lastPage(),
        ]);
    }

    public function all(Request $request)
    {
        $query = ElectricBike::query()->where('active', '!=', 0);

        $objects = $query->select(['slug'])->get();

        return response()->json($objects);
    }

    public function singleBike(ElectricBike $bike, $slug)
    {
        return response()->json(ElectricBike::where('slug', $slug)->where('active', '!=', 0)->first());
    }

    public function index()
    {
        $bikes = ElectricBike::all()->sortByDesc('active');
        return view('bikes.index', compact('bikes'));
    }

    public function json()
    {
        $bikes = ElectricBike::all()->sortByDesc('active')->values();
        foreach ($bikes as $bike) {
            unset($bike->created_at);
            unset($bike->updated_at);
        }
        return response()->json($bikes);
    }
    public function jsonMakes(Request $request)
    {
        $bikes = ElectricBike::select('make', DB::raw('count(*) as total'))
            ->where('active', '!=', 0)
            ->groupBy('make')->orderByDesc('total');

        if ($request->has('make')) {
            // $bikes->where('make', str_replace('-', ' ', $request->input('make')))->first();
            $bikes->where('make', str_replace('-', ' ', $request->input('make')))->orWhere('make', $request->input('make'));

        }

        //        $vehicles = $vehicles->values()->sortBy('make');
//        $vehicles = $vehicles->sortBy('make');
//        $vehicles = $vehicles->sortBy('make');
        $arr = $bikes->get()->map(function ($bike) {
            $make = $bike->make;
            return [
                'name' => $make,
                'slug' => str_replace(' ', '-', strtolower($make))
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

    public function save(Request $request)
    {
        $data = $request->all();
        $validated = $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'title' => 'required|string',
            'speed' => 'integer|nullable',
            'range' => 'integer|nullable',
            'description' => 'string|nullable',
            'short_description' => 'string|nullable',
            'review' => 'string|nullable',
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
            'slug' => 'string',
            'active' => 'numeric|nullable'
        ]);
        if (isset($data['id'])) {
            $bike = ElectricBike::find($data['id']);
            $bike->update($validated);
        } else {
            $slug = (empty($validated['slug']))
                ? Str::slug($data['make'] . ' ' . $data['model'], '-')
                : $validated['slug'];
            $bike = ElectricBike::create([
                'make' => $validated['make'],
                'model' => $validated['model'],
                'title' => $validated['title'],
                'speed' => $validated['speed'],
                'range' => $validated['range'],
                'description' => $validated['description'],
                'short_description' => $validated['short_description'],
                'review' => $validated['review'],
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
                'active' => $validated['active'],
                'slug' => $slug
            ]);
        }
        return response()->json([$bike, 201]);
    }
    public function edit(ElectricBike $bike)
    {
        return view('bikes.edit', compact('bike'));
    }

    public function destroy(ElectricBike $bike)
    {
        $bike->delete();
        return redirect(route('bikes.index'))->with('notification', '"' . $bike->make . ' ' . $bike->model . '" deleted!');
    }
    public function create()
    {
        return view('bikes.create');
    }
}