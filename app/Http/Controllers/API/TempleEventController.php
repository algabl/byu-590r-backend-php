<?php

namespace App\Http\Controllers\API;

use App\Models\TempleEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TempleEventController extends BaseController
{
    //
    public function index()
    {
        // Return a list of temple events
    }
    public function show($id)
    {
        // Return a specific temple event
    }
    public function store(Request $request)
    {
        // Store a new temple event
        $validator = Validator::make($request->all(), [
            'temple_id' => 'required|exists:temples,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), code: 400);
        }

        $event = new TempleEvent();
        $event->temple_id = $request->temple_id;
        $event->name = $request->name;
        $event->date = $request->date;
        $event->description = $request->description;
        $event->save();
        return $this->sendResponse($event, 'Temple event created successfully.');
    }

    public function update(Request $request, $id)
    {
        // Update a specific temple event
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'description' => 'sometimes|nullable|string|max:1000',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $event = TempleEvent::findOrFail($id);

        if ($request->has('name')) {
            $event->name = $request->name;
        }
        if ($request->has('date')) {
            $event->date = $request->date;
        }
        if ($request->has('description')) {
            $event->description = $request->description;
        }
        $event->save();
        return $this->sendResponse($event, 'Temple event updated successfully.');
    }
    public function destroy($id)
    {
        // Delete a specific temple event
        $event = TempleEvent::findOrFail($id);
        $event->delete();
        return $this->sendResponse([], 'Temple event deleted successfully.');
    }
}
