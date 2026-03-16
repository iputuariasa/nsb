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
        $title = 'Data Kredit';

        $query = Loan::with(['ao', 'reference', 'pillar', 'region', 'histories.user']);

        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('phone_number', 'like', "%{$search}%")
                ->orWhere('application_date', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
                // tambah field lain kalau perlu
            });
        }

        $loans = $query->orderBy('id', 'desc')->paginate(100);

        $branches = Branch::all();
        $users = User::all();
        $pillars = Pillar::all();
        $ao = User::all();

        return view('loans.registers.index', compact(
            'loans', 'branches', 'title', 'users', 'pillars','ao'
        ))->with('loansCollection', $loans->getCollection());
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
