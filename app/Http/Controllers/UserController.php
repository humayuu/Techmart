<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::latest()->get();

            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('last_seen', function ($row) {
                    if (! $row->last_seen) {
                        return 'Never';
                    }

                    $isOnline = $row->last_seen >= Carbon::now()->subMinutes(0.01);

                    // Don't show last_seen time if user is currently online
                    return $isOnline ? '' : $row->last_seen->diffForHumans();
                })
                ->addColumn('status', function ($row) {
                    if (! $row->last_seen) {
                        return '<span class="badge fs-3 bg-secondary">Offline</span>';
                    }

                    $isOnline = $row->last_seen >= Carbon::now()->subMinutes(0.01);

                    return $isOnline
                        ? '<span class="badge fs-5 bg-primary">Online</span>'
                        : '<span class="badge fs-5 bg-dark">Offline</span>';
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $totalUsers = User::count();

        return view('admin.user.index', compact('totalUsers'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
