<?php

namespace App\Http\Controllers;

use App\Models\Droit;
use Illuminate\Http\Request;

class DroitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public static function getDroit($type)
    {
        if($type === "MR")
            return Droit::where('typeDroit', "M2R")->value('montantDroit');
        return Droit::where('typeDroit', $type)->value('montantDroit');
    }

    public static function getIdDroit($type)
    {
        if($type === "MR")
            return Droit::where('typeDroit', "M2R")->first()->idDroit;
        return Droit::where('typeDroit', $type)->first()->idDroit;
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
     * @param  \App\Models\Droit  $droit
     * @return \Illuminate\Http\Response
     */
    public function show(Droit $droit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Droit  $droit
     * @return \Illuminate\Http\Response
     */
    public function edit(Droit $droit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Droit  $droit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Droit $droit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Droit  $droit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Droit $droit)
    {
        //
    }
}
