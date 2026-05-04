<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\CooperativeRequest;
use Illuminate\Http\Request;

class CooperativeRequestController extends Controller
{
    private function success($data = null, string $message = 'Success', int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public function index(Request $request)
    {
        $items = CooperativeRequest::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return $this->success($items, 'My cooperative requests');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cooperative_name' => 'required|string|max:255|unique:cooperative_requests,cooperative_name',
            'cooperative_type' => 'required|string|max:100',
            'initial_members' => 'required|integer|min:10',
            'objective' => 'required|string',
            'address' => 'required|string',
        ]);

        $item = CooperativeRequest::create([
            'user_id' => $request->user()->id,
            ...$validated,
            'status' => 'pending',
        ]);

        return $this->success($item, 'Cooperative request created successfully', 201);
    }

    public function show(Request $request, int $id)
    {
        $item = CooperativeRequest::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Cooperative request not found',
                'errors' => null,
            ], 404);
        }

        return $this->success($item, 'Cooperative request detail');
    }
}