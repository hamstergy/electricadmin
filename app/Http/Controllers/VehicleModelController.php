<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VehicleModel;
use Illuminate\Support\Str;

class VehicleModelController extends Controller
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
    public function __construct(VehicleModel $model)
    {
        $this->model = $model;
    }

    /**
     * Show make models list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function models($make)
    {
        $models = $this->model->byMake($make)->orderBy('name')->get(['id', 'name', 'class']);

        return response()->json([
            'models' => $models
        ]);
    }

    public function index() {
        $models = VehicleModel::latest()->get();
        return view('models.index', compact('models'));
    }

    public function show(VehicleModel $model)
    {
        return view('models.show', compact('model'));
    }

    public function save(Request $request) {
        $data = $request->all();
        $validated = $request->validate([
            'name' => 'required|string',
            'class' => 'required|string',
            'description' => 'string',
            'detail' => 'string',
            'price' => 'integer',
            'lease' => 'integer',
            'finance' => 'integer',
            'image' => 'string',
            'video' => 'string',
            'vehicle_make_id' => 'required|integer'
        ]);
        if(isset($data['id'])) {
            $model = VehicleModel::find($data['id']);
            $model->update($validated);
        } else {
            $slug = Str::slug($data['name'],'-');
            $model = VehicleModel::create([
                'name' => $validated['name'],
                'vehicle_make_id' => $validated['vehicle_make_id'],
                'class' => $validated['class'],
                'description' => $validated['description'],
                'detail' => $validated['detail'],
                'price' => $validated['price'],
                'lease' => $validated['lease'],
                'finance' => $validated['finance'],
                'image' => $validated['image'],
                'video' => $validated['video'],
                'slug' => $slug
            ]);
        }
        return response()->json([$model,201]);
    }
    public function edit(VehicleModel $model)
    {
        return view('models.edit', compact('model'));
    }

    public function destroy(VehicleModel $model)
    {
        $model->delete();
        return redirect(route('models.index'))->with('notification', '"' . $model->name .  '" deleted!');
    }
    public function create() {
        return view('models.create');
    }
}
