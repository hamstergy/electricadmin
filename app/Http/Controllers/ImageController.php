<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\ElectricVehicle;

class ImageController extends Controller
{
    public function index() {
        return view('image');
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [   'img' => 'required|image',
                'type' => 'required|string',
                'make' => 'string',
                'model'=>'string'
            ]);

        if($request->hasfile('img'))
        {
            $file = $request->file('img');
            $name=$request->make.'-'.$request->model.'-'.$request->type.'.jpg';
            imagewebp(
                imagecreatefromstring(file_get_contents($file)),
                $name,
                80);
            $filePath = 'images/'.$request->make.'/'. $name;
            Storage::disk('s3')->put($filePath, file_get_contents($name), 'public');
            unlink($name);
            return response()->json([ $filePath, 201]);
        }
        return response()->json(false);
    }

    public function delete(Request $request)
    {
        $d =  Storage::disk('s3')->delete('images/' . $request['data']);
        return response()->json($d);
    }

    public function webp()
    {
        $vehicles = ElectricVehicle::select('make', 'imageSlug')->distinct()->get();
//        $vehicles = ElectricVehicle::where('id', '>', 191)->get();
        foreach ($vehicles as $vehicle) {
            var_dump($vehicle->imageSlug);
//            $this->generate_webp($vehicle->make, $vehicle->imageSlug, 'large');
            $this->generate_webp($vehicle->make, $vehicle->imageSlug, 'medium');
            $this->generate_webp($vehicle->make, $vehicle->imageSlug, 'mobile');
        }
        return response()->json(True);
//        $url = "https://hamstercar.s3-us-west-2.amazonaws.com/images/chevrolet/Chevrolet-Blazer-EV-large.jpg";
//        $name='Chevrolet-Blazer-EV-large.webp';
//        $filePath = 'images/chevrolet/'. $name;
//        $old_url = imagecreatefromstring(file_get_contents($url));
//        imagewebp(
//            $old_url,
//            $name,
//            80);
//
//        Storage::disk('s3')->put($filePath, file_get_contents($name), 'public');
//        unlink($name);
//        return response()->json(True);
    }

    private function generate_webp($make, $slug, $size) {
        $url = "https://hamstercar.s3-us-west-2.amazonaws.com/images/".str_replace(' ', '-', strtolower($make))."/".$slug."-".$size.".jpg";
        $name=strtolower($slug).'-'.$size.'.webp';
        $filePath = 'images/'.str_replace(' ', '-', strtolower($make)).'/'. $name;
        $old_url = imagecreatefromstring(file_get_contents($url));
        imagewebp(
            $old_url,
            $name,
            80);
        Storage::disk('s3')->put($filePath, file_get_contents($name), 'public');
        unlink($name);
        return True;
    }
}
