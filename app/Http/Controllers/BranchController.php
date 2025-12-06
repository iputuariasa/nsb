<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Cabang';
        $branches = Branch::all();
        return view('admin.branches.index', compact('branches','title'));
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
        $validated = $request->validate([
            'central_code' => 'required|string|max:10',
            'branch_code' => 'required|string|min:4|unique:branches,branch_code',
            'central_name' => 'required|string',
            'branch_name' => 'required|string',
        ]);

        $branch = Branch::create($validated);

        return response()->json([
            'message' => 'Data cabang berhasil disimpan',
            'branch' => $branch
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'central_code' => 'required|string|max:10',
            'branch_code' => 'required|string|min:4|unique:branches,branch_code,' . $branch->id,
            'central_name' => 'required|string',
            'branch_name' => 'required|string',
        ]);

        $branch->update($validated);

        return response()->json([
            'message' => 'Data cabang berhasil diupdate',
            'branch' => $branch
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();

        return response()->json([
            'message' => 'Data cabang berhasil dihapus'
        ]);
    }
}
