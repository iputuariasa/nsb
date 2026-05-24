<?php

namespace App\Http\Controllers;

use App\Models\HeadOffice;
// use Illuminate\Http\Request;

class OrganizationStructureController extends Controller
{
    public function index()
    {
        $title = 'Data Jaringan Kantor';
        $headOffices = HeadOffice::with([
            'branches' => function($query) {
                $query->orderBy('code');
            },
            'branches.kiosks' => function($query) {
                $query->orderBy('code');
            }
        ])
        ->orderBy('code')
        ->get();

        return view('admin.office_network.index', compact('headOffices', 'title'));
    }
}
