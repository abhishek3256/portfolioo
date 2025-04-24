<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Startup;
use App\Models\StartupMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StartupMetricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $startupId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $startupId)
    {
        $startup = Startup::findOrFail($startupId);
        
        $query = $startup->metrics()->orderBy('date', 'desc');
        
        // Filter by metric name if provided
        if ($request->has('metric_name')) {
            $query->where('metric_name', $request->metric_name);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }
        
        $metrics = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $metrics,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $startupId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $startupId)
    {
        $startup = Startup::findOrFail($startupId);

        $validator = Validator::make($request->all(), [
            'metric_name' => 'required|string|max:255',
            'metric_value' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $metric = $startup->metrics()->create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Metric created successfully',
            'data' => $metric,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $startupId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($startupId, $id)
    {
        $startup = Startup::findOrFail($startupId);
        $metric = $startup->metrics()->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $metric,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $startupId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $startupId, $id)
    {
        $startup = Startup::findOrFail($startupId);
        $metric = $startup->metrics()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'metric_name' => 'sometimes|required|string|max:255',
            'metric_value' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $metric->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Metric updated successfully',
            'data' => $metric,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $startupId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($startupId, $id)
    {
        $startup = Startup::findOrFail($startupId);
        $metric = $startup->metrics()->findOrFail($id);
        $metric->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Metric deleted successfully',
        ]);
    }

    /**
     * Get metrics history for a specific metric name.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $startupId
     * @return \Illuminate\Http\Response
     */
    public function metricHistory(Request $request, $startupId)
    {
        $validator = Validator::make($request->all(), [
            'metric_name' => 'required|string',
            'months' => 'nullable|integer|min:1|max:36',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $startup = Startup::findOrFail($startupId);
        $metricName = $request->metric_name;
        $months = $request->input('months', 12);

        $startDate = now()->subMonths($months)->startOfMonth()->format('Y-m-d');

        $metrics = $startup->metrics()
                    ->where('metric_name', $metricName)
                    ->where('date', '>=', $startDate)
                    ->orderBy('date')
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'metric_name' => $metricName,
                'history' => $metrics,
            ],
        ]);
    }
}