<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Temple;
use App\Models\TempleDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'status' => 'required',
            'walk_score' => 'integer',
            'bike_score' => 'integer',
            'transit_score' => 'integer',
            'temple_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'temple_details.architect' => 'string|max:255',
            'temple_details.square_footage' => 'integer',
            'temple_details.number_ordinance_rooms' => 'integer',
            'temple_details.number_sealing_rooms' => 'integer',
            'temple_details.number_surface_parking_spots' => 'integer',
            'temple_details.additional_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), code: 400);
        }


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

        $templeDetails = new TempleDetails();
        $templeDetails->temple_id = $temple->id;
        $templeDetails->architect = $request->temple_details['architect'];
        $templeDetails->square_footage = $request->temple_details['square_footage'];
        $templeDetails->number_ordinance_rooms = $request->temple_details['number_ordinance_rooms'];
        $templeDetails->number_sealing_rooms = $request->temple_details['number_sealing_rooms'];
        $templeDetails->number_surface_parking_spots = $request->temple_details['number_surface_parking_spots'];
        $templeDetails->additional_notes = $request->temple_details['additional_notes'];
        $templeDetails->save();

        $temple->load('templeDetails');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'status' => 'required',
            'walk_score' => 'integer',
            'bike_score' => 'integer',
            'transit_score' => 'integer',
            'temple_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'temple_details.architect' => 'string|max:255',
            'temple_details.square_footage' => 'integer',
            'temple_details.number_ordinance_rooms' => 'integer',
            'temple_details.number_sealing_rooms' => 'integer',
            'temple_details.number_surface_parking_spots' => 'integer',
            'temple_details.additional_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), code: 400);
        }

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
        // return $this->sendResponse($request->temple_details, "Hey");

        if ($request->temple_details != null) {
            $templeDetails = TempleDetails::where('temple_id', $temple->id)->first();
            if (!$templeDetails) {
                $templeDetails = new TempleDetails();
                $templeDetails->temple_id = $temple->id;
            }
            if ($request->temple_details['architect']) {
                $templeDetails->architect = $request->temple_details['architect'];
            }
            if ($request->temple_details['square_footage']) {
                $templeDetails->square_footage = $request->temple_details['square_footage'];
            }
            if ($request->temple_details['number_ordinance_rooms']) {
                $templeDetails->number_ordinance_rooms = $request->temple_details['number_ordinance_rooms'];
            }
            if ($request->temple_details['number_sealing_rooms']) {
                $templeDetails->number_sealing_rooms = $request->temple_details['number_sealing_rooms'];
            }
            if ($request->temple_details['number_surface_parking_spots']) {
                $templeDetails->number_surface_parking_spots = $request->temple_details['number_surface_parking_spots'];
            }
            if ($request->temple_details['additional_notes']) {
                $templeDetails->additional_notes = $request->temple_details['additional_notes'];
            }
            $templeDetails->save();
        }

        $temple->load('templeDetails');
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
