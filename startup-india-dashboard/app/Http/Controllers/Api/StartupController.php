<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Startup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StartupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Startup::query();

        // Apply filters if provided
        if ($request->has('industry')) {
            $query->where('industry', $request->industry);
        }

        if ($request->has('stage')) {
            $query->where('stage', $request->stage);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Apply sorting
        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->input('per_page', 10);
        $startups = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $startups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'founder_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'founding_date' => 'nullable|date',
            'industry' => 'required|string|max:100',
            'stage' => 'required|in:idea,pre-seed,seed,early,growth,mature',
            'funding_amount' => 'nullable|numeric',
            'employee_count' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,acquired,closed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $startup = Startup::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Startup created successfully',
            'data' => $startup,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $startup = Startup::with(['milestones', 'fundingRounds', 'metrics'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $startup,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $startup = Startup::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'founder_name' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'founding_date' => 'nullable|date',
            'industry' => 'sometimes|required|string|max:100',
            'stage' => 'sometimes|required|in:idea,pre-seed,seed,early,growth,mature',
            'funding_amount' => 'nullable|numeric',
            'employee_count' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'status' => 'sometimes|required|in:active,inactive,acquired,closed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $startup->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Startup updated successfully',
            'data' => $startup,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $startup = Startup::findOrFail($id);
        $startup->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Startup deleted successfully',
        ]);
    }

    /**
     * Get startup stats for dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function stats()
    {
        $totalStartups = Startup::count();
        $activeStartups = Startup::where('status', 'active')->count();
        $totalFunding = Startup::sum('funding_amount');
        $industryDistribution = Startup::selectRaw('industry, count(*) as count')
            ->groupBy('industry')
            ->orderByDesc('count')
            ->get();
        $stageDistribution = Startup::selectRaw('stage, count(*) as count')
            ->groupBy('stage')
            ->orderBy('stage')
            ->get();
        $locationDistribution = Startup::selectRaw('location, count(*) as count')
            ->groupBy('location')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_startups' => $totalStartups,
                'active_startups' => $activeStartups,
                'total_funding' => $totalFunding,
                'industry_distribution' => $industryDistribution,
                'stage_distribution' => $stageDistribution,
                'location_distribution' => $locationDistribution,
            ],
        ]);
    }
}