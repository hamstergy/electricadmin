<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class ElectricImageController extends Controller
{
    public function index()
    {
        return view('image');
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'img' => 'required|image',
                'type' => 'required|string',
                'make' => 'string',
                'model' => 'string'
            ]
        );

        if ($request->hasfile('img')) {
            $make = str_replace(' ', '-', $request->make);
            $file = $request->file('img');
            $name = $request->model . '-' . $request->type . '.webp';
            $filePath = 'images/' . $make . '/' . $name;
            imagewebp(
                imagecreatefromstring(file_get_contents($file)),
                $name,
                80
            );
            Storage::disk('s3')->put($filePath, file_get_contents($name), 'public');
            unlink($name);
            return response()->json([$filePath, 201]);
        }
        return response()->json(false);
    }

    public function storeBike(Request $request)
    {
        $this->validate(
            $request,
            [
                'img' => 'required|image',
                'type' => 'required|string',
                'make' => 'string',
                'model' => 'string'
            ]
        );

        if ($request->hasfile('img')) {
            $make = str_replace(' ', '-', $request->make);
            $file = $request->file('img');
            $name = $request->model . '-' . $request->type . '.webp';
            $filePath = 'bike-images/' . $make . '/' . $name;
            imagewebp(
                imagecreatefromstring(file_get_contents($file)),
                $name,
                80
            );
            Storage::disk('s3')->put($filePath, file_get_contents($name), 'public');
            unlink($name);
            return response()->json([$filePath, 201]);
        }
        return response()->json(false);
    }

    public function delete(Request $request)
    {
        $d = Storage::disk('s3')->delete('images/' . $request['data']);
        return response()->json($d);
    }
}