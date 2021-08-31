<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VehicleMake;
use Illuminate\Support\Str;

class VehicleMakeController extends Controller
{
    /**
     * Model instance.
     *
     * @var mixed
     */
    public $model;

    /**
     * Create a new ModelsController instance.
     *
     * @return void
     */
    public function __construct(VehicleMake $model)
    {
        $this->model = $model;
    }

    /**
     * Show makes list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function makes()
    {
        $makes = $this->model->orderBy('name')->get(['id', 'name']);

        return response()->json([
            'makes' => $makes
        ]);
    }

    public function index() {
        $makes = VehicleMake::latest()->get();
        return view('makes.index', compact('makes'));
    }

    public function create() {
        return view('makes.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|unique:vehicle_makes'
        ]);
        $validated['slug'] = Str::slug($validated['name'], '-');
        $make = $this->create($validated);
        return redirect(route('makes.show', [$make->slug]))->with('notification', 'Post created');
    }

    public function save(Request $request) {
        $data = $request->all();

        $validated = $request->validate([
            'name' => 'required|string|unique:vehicle_makes'
        ]);

        if(isset($data['id'])) {
            $make = VehicleMake::find($data['id']);
            $make->update($validated);
        } else {
            $slug = Str::slug($data['name'],'-');
            $make = VehicleMake::create([
                'name' => $data['name'],
                'slug' => $slug
            ]);
        }
        return response()->json([$make,201]);
    }

    public function show(VehicleMake $make)
    {
        return view('makes.show', compact('make'));
    }

    public function edit(VehicleMake $make)
    {
        return view('makes.edit', compact('make'));
    }

    public function destroy(VehicleMake $make)
    {
        $make->delete();
        return redirect(route('makes.index'))->with('notification', '"' . $make->name .  '" deleted!');
    }
}
