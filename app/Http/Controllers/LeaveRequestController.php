<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required',
            'attachment' => 'required|file|mimes:pdf,jpg,png|max:2048'
        ]);

        if (Carbon::parse($request->start_date)->lt(now()->startOfDay())) {
            return response()->json([
                'message' => 'Tanggal cuti tidak boleh sebelum hari ini'
            ], 400);
        }


        $user = $request->user();

        $days = Carbon::parse($request->start_date)
            ->diffInDays(Carbon::parse($request->end_date)) + 1;

        $totalLeave = LeaveRequest::where('user_id', $user->id)
            ->whereYear('start_date', now()->year)
            ->where('status', 'approved')
            ->sum('days');

        if ($totalLeave + $days > 12) {
            return response()->json([
                'message' => 'Cuti melebihi batas 12 hari'
            ], 400);
        }

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments', 'public');
        }

        $leave = LeaveRequest::create([
            'user_id' => $user->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days' => $days,
            'reason' => $request->reason,
            'attachment' => $filePath,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Pengajuan cuti berhasil',
            'data' => $leave
        ]);
    }
    public function myLeaves(Request $request)
    {
        $user = $request->user();

        $leaves = LeaveRequest::where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data cuti saya',
            'data' => $leaves
        ]);
    }
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        $leaves = LeaveRequest::latest()->get();

        return response()->json([
            'message' => 'Semua data cuti',
            'data' => $leaves
        ]);
    }
    public function approve($id, Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $leave = LeaveRequest::findOrFail($id);

        if ($leave->status !== 'pending') {
            return response()->json([
                'message' => 'Request sudah diproses'
            ], 400);
        }

        $days = $leave->days;

        $totalLeave = LeaveRequest::where('user_id', $leave->user_id)
            ->whereYear('start_date', now()->year)
            ->where('status', 'approved')
            ->sum('days');

        if ($totalLeave + $days > 12) {
            return response()->json([
                'message' => 'Tidak bisa approve, kuota cuti melebihi 12 hari'
            ], 400);
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => $user->id,
            'approved_at' => now()
        ]);

        return response()->json([
            'message' => 'Cuti disetujui',
            'data' => $leave
        ]);
    }
    public function reject($id, Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $leave = LeaveRequest::findOrFail($id);
        if ($leave->status !== 'pending') {
            return response()->json([
                'message' => 'Request sudah diproses'
            ], 400);
        }

        $leave->update([
            'status' => 'rejected',
            'approved_by' => $user->id,
            'approved_at' => now()
        ]);

        return response()->json([
            'message' => 'Cuti ditolak',
            'data' => $leave
        ]);
    }
}
