<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FundingRound;
use App\Models\Startup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FundingRoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $startupId
     * @return \Illuminate\Http\Response
     */
    public function index($startupId)
    {
        $startup = Startup::findOrFail($startupId);
        $fundingRounds = $startup->fundingRounds()->orderBy('date', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $fundingRounds,
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
            'round_type' => 'required|in:pre-seed,seed,series_a,series_b,series_c,series_d,other',
            'amount' => 'required|numeric',
            'investors' => 'nullable|string',
            'date' => 'required|date',
            'valuation' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $fundingRound = $startup->fundingRounds()->create($request->all());

        // Update the startup's total funding amount
        $totalFunding = $startup->fundingRounds()->sum('amount');
        $startup->funding_amount = $totalFunding;
        $startup->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Funding round created successfully',
            'data' => $fundingRound,
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
        $fundingRound = $startup->fundingRounds()->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $fundingRound,
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
        $fundingRound = $startup->fundingRounds()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'round_type' => 'sometimes|required|in:pre-seed,seed,series_a,series_b,series_c,series_d,other',
            'amount' => 'sometimes|required|numeric',
            'investors' => 'nullable|string',
            'date' => 'sometimes|required|date',
            'valuation' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $fundingRound->update($request->all());

        // Update the startup's total funding amount
        $totalFunding = $startup->fundingRounds()->sum('amount');
        $startup->funding_amount = $totalFunding;
        $startup->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Funding round updated successfully',
            'data' => $fundingRound,
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
        $fundingRound = $startup->fundingRounds()->findOrFail($id);
        $fundingRound->delete();

        // Update the startup's total funding amount
        $totalFunding = $startup->fundingRounds()->sum('amount');
        $startup->funding_amount = $totalFunding;
        $startup->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Funding round deleted successfully',
        ]);
    }
}