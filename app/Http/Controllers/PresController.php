<?php

namespace App\Http\Controllers;

use App\Models\Candidats\CandidatL;
use Illuminate\Http\Request;

class PresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('menu.preselection');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidats\CandidatL  $candidatL
     * @return \Illuminate\Http\Response
     */
    public function show(CandidatL $candidatL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidats\CandidatL  $candidatL
     * @return \Illuminate\Http\Response
     */
    public function edit(CandidatL $candidatL)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidats\CandidatL  $candidatL
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CandidatL $candidatL)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidats\CandidatL  $candidatL
     * @return \Illuminate\Http\Response
     */
    public function destroy(CandidatL $candidatL)
    {
        //
    }
}
