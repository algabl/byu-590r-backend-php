<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Temple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class TempleController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $temples = Temple::with(['templeDetails', 'templeEvents'])->get(); // Eager load related data
        foreach ($temples as $temple) {
            $temple->temple_image = $this->getS3Url($temple->temple_image);
        }
        return $this->sendResponse($temples, 'Temples retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $temple = new Temple();
        $temple->name = $request->name;
        $temple->latitude = $request->latitude;
        $temple->longitude = $request->longitude;
        $temple->status = $request->status;
        $temple->walk_score = $request->walk_score;
        $temple->bike_score = $request->bike_score;
        $temple->transit_score = $request->transit_score;
        if ($request->hasFile('temple_image')) {
            // dd($request->file('temple_image'));
            $extension = $request->file('temple_image')->getClientOriginalExtension();
            $image_name = time() . '.' . $extension;
            $path = $request->file('temple_image')->storeAs(
                'images',
                $image_name,
                's3'
            );
            Storage::disk('s3')->setVisibility($path, "public");
            $temple->temple_image = $path;
        }
        $temple->save();
        $temple->temple_image = $this->getS3Url($temple->temple_image);
        return $this->sendResponse($temple, 'Temple created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $temple = Temple::findOrFail($id);
        if ($request->has('name')) {
            $temple->name = $request->name;
        }
        if ($request->has('latitude')) {
            $temple->latitude = $request->latitude;
        }
        if ($request->has('longitude')) {
            $temple->longitude = $request->longitude;
        }
        if ($request->has('status')) {
            $temple->status = $request->status;
        }
        if ($request->has('walk_score')) {
            $temple->walk_score = $request->walk_score;
        }
        if ($request->has('bike_score')) {
            $temple->bike_score = $request->bike_score;
        }
        if ($request->has('transit_score')) {
            $temple->transit_score = $request->transit_score;
        }
        if ($request->hasFile('temple_image')) {
            // delete the old image from s3
            if ($temple->temple_image) {
                Storage::disk('s3')->delete($temple->temple_image);
            }
            $extension = $request->file('temple_image')->getClientOriginalExtension();
            $image_name = time() . '.' . $extension;
            $path = $request->file('temple_image')->storeAs(
                'images',
                $image_name,
                's3'
            );
            Storage::disk('s3')->setVisibility($path, "public");
            $temple->temple_image = $path;
        }
        $temple->save();
        $temple->temple_image = $this->getS3Url($temple->temple_image);
        return $this->sendResponse($temple, 'Temple updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $temple = Temple::findOrFail($id);
        // delete the image from s3
        if ($temple->temple_image) {
            Storage::disk('s3')->delete($temple->temple_image);
        }
        $temple->delete();
        return $this->sendResponse(null, 'Temple deleted successfully.');
    }
}
