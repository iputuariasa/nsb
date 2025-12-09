<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Branch;
use App\Models\LoanStatusHistory;
use App\Models\Pillar;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title    = 'Data Kredit';
        $branches = Branch::all();           // kalau kamu pakai branch
        $users    = User::all();             // untuk dropdown AO / Referrer
        $pillars  = Pillar::all();           // untuk dropdown sumber data

        // EAGER LOADING YANG BENAR
        $loans = Loan::with([
            'ao',           // ← nama AO (ao_id → User)
            'reference',     // ← nama yang ngajuin (reference_id → User)
            'pillar',       // ← nama pillar (pillar_id → Pillar)
            'histories.user', // ← biar timeline bisa tampilkan siapa yang ubah status
        ])
        ->latest()           // optional: urutkan dari yang terbaru
        ->get();

        return view('loans.registers.index', compact(
            'loans',
            'branches',
            'title',
            'users',
            'pillars'
        ));
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
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
