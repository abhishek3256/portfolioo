<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use App\Models\Startup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MilestoneController extends Controller
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
        $milestones = $startup->milestones()->orderBy('date')->get();

        return response()->json([
            'status' => 'success',
            'data' => $milestones,
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'status' => 'required|in:planned,in_progress,completed,delayed',
            'type' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $milestone = $startup->milestones()->create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Milestone created successfully',
            'data' => $milestone,
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
        $milestone = $startup->milestones()->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $milestone,
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
        $milestone = $startup->milestones()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:planned,in_progress,completed,delayed',
            'type' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $milestone->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Milestone updated successfully',
            'data' => $milestone,
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
        $milestone = $startup->milestones()->findOrFail($id);
        $milestone->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Milestone deleted successfully',
        ]);
    }
}