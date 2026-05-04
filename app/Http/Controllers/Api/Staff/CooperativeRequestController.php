<?php

namespace App\Http\Controllers\Api\Staff;

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

    private function error(string $message, $errors = null, int $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    public function index(Request $request)
    {
        $query = CooperativeRequest::with(['user', 'reviewer'])->latest();

        if ($request->filled('status')) {
            $request->validate([
                'status' => 'in:pending,approved,rejected',
            ]);

            $query->where('status', $request->status);
        }

        return $this->success($query->get(), 'Cooperative request list');
    }

    public function show(int $id)
    {
        $item = CooperativeRequest::with(['user', 'reviewer'])->find($id);

        if (!$item) {
            return $this->error('Cooperative request not found', null, 404);
        }

        return $this->success($item, 'Cooperative request detail');
    }

    public function approve(Request $request, int $id)
    {
        $item = CooperativeRequest::find($id);

        if (!$item) {
            return $this->error('Cooperative request not found', null, 404);
        }

        if ($item->status !== 'pending') {
            return $this->error('This request has already been reviewed.', null, 422);
        }

        $validated = $request->validate([
            'review_note' => 'required|string',
        ]);

        $item->update([
            'status' => 'approved',
            'review_note' => $validated['review_note'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return $this->success($item, 'Cooperative request approved successfully');
    }

    public function reject(Request $request, int $id)
    {
        $item = CooperativeRequest::find($id);

        if (!$item) {
            return $this->error('Cooperative request not found', null, 404);
        }

        if ($item->status !== 'pending') {
            return $this->error('This request has already been reviewed.', null, 422);
        }

        $validated = $request->validate([
            'review_note' => 'required|string',
        ]);

        $item->update([
            'status' => 'rejected',
            'review_note' => $validated['review_note'],
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return $this->success($item, 'Cooperative request rejected successfully');
    }
}