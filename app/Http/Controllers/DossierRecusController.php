<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DossierRecusController extends Controller
{
    public function index()
    {
        return view('menu.dossierrecu');
    }
}
