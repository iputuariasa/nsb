<?php

namespace App\Http\Controllers;

use App\Models\Pillar;
use Illuminate\Http\Request;

class PillarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Pilar';
        $pillars = Pillar::all();
        return view('loans.pillars.index', compact('pillars','title'));
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
            'name' => 'required|string',
        ]);

        $pillar = Pillar::create($validated);

        return response()->json([
            'message' => 'Data pilar berhasil disimpan',
            'pillar' => $pillar
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pillar $pillar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pillar $pillar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pillar $pillar)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        $pillar->update($validated);

        return response()->json([
            'message' => 'Data pilar berhasil diupdate',
            'pillar' => $pillar
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pillar $pillar)
    {
        $pillar->delete();

        return response()->json([
            'message' => 'Data pilar berhasil dihapus'
        ]);
    }
}
