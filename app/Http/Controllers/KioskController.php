<?php

namespace App\Http\Controllers;

use App\Models\Kiosk;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'branch_id' => 'required|exists:branches,id',
            'name'    => 'required|string|max:255',
            'code'    => 'required|string|unique:kiosks,code',
            'address' => 'nullable|string',
            'phone'   => 'nullable|string',
            'email'   => 'nullable|email|max:255',
        ]);

        $kiosk = Kiosk::create($validated);

        return response()->json([
            'message' => 'Data kiosk berhasil ditambahkan',
            'kiosk' => $kiosk
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kiosk $kiosk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kiosk $kiosk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kiosk $kiosk)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'code'    => 'required|string|unique:kiosks,code,' . $kiosk->id,
            'address' => 'nullable|string',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'nullable|email|max:255',
        ]);

        $kiosk->update($validated);

        return response()->json([
            'message' => 'Data kiosk berhasil diupdate',
            'kiosk' => $kiosk
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kiosk $kiosk)
    {
        $kiosk->delete();

        return response()->json([
            'message' => 'Data kiosk berhasil dihapus'
        ]);
    }
}
