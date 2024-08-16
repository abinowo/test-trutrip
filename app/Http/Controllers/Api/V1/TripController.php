<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Cache;
use Validator;

class TripController extends Controller
{
    public function index()
    {
        try {
            $trips = Trip::all();
            return $this->onSuccess(tr_first('app.success', ['message' => '']), $trips);
        } catch (\Exception $e) {
            return $this->onFailed(tr_first('app.failed'), $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'origin' => 'required|string|max:255',
                'destination' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'type_of_trip' => 'required|in:single_day,multi_day',
                'description' => 'nullable|string',
            ]);

            // validation
            if ($validator->fails()) {
                return $this->onFailed(tr('app.failed'), [
                    'errors' => $validator->errors()
                ]);
            }

            // Create a new trip
            $trip = Trip::create([
                'title' => $request->title,
                'origin' => $request->origin,
                'destination' => $request->destination,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'type_of_trip' => $request->type_of_trip,
                'description' => $request->description,
            ]);
            return $this->onSuccess(tr_first('app.success', ['message' => '']), $trip);
        } catch (\Exception $e) {
            return $this->onFailed(tr_first('app.failed'), $e->getMessage());
        }
    }

    public function show(Trip $trip)
    {
        if (app()->environment('testing')) {
            return $this->onSuccess(tr_first('app.success', ['message' => '']), $trip);
        }

        try {
            $cacheKey = 'trip_show';
            $ttl = 60; // 60 minutes
            $data = Cache::remember($cacheKey, $ttl, function () use ($trip) {
                return $trip;
            });
            return $this->onSuccess(tr_first('app.success', ['message' => '']), $data);
        } catch (\Exception $e) {
            return $this->onFailed(tr_first('app.failed'), $e->getMessage());
        }
    }

    public function update(Request $request, Trip $trip)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'origin' => 'required|string|max:255',
                'destination' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'type_of_trip' => 'required|in:single_day,multi_day',
                'description' => 'nullable|string',
            ]);

            // validation
            if ($validator->fails()) {
                return $this->onFailed(tr('app.failed'), [
                    'errors' => $validator->errors()
                ]);
            }

            // Create a new trip
            $trip->update([
                'title' => $request->title,
                'origin' => $request->origin,
                'destination' => $request->destination,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'type_of_trip' => $request->type_of_trip,
                'description' => $request->description,
            ]);
            return $this->onSuccess(tr_first('app.success', ['message' => '']), $trip);
        } catch (\Exception $e) {
            return $this->onFailed(tr_first('app.failed'), $e->getMessage());
        }
    }

    public function destroy(Trip $trip)
    {
        try {
            $trip->delete();
            return $this->onSuccess(tr_first('app.success', ['message' => '']));
        } catch (\Exception $e) {
            return $this->onFailed(tr_first('app.failed'), $e->getMessage());
        }
    }
}
