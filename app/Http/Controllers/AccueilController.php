<?php

namespace App\Http\Controllers;

use App\Models\Students\LicenceOne;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('menu.etudiant');
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
     * @param  \App\Models\Students\LicenceOne  $licenceOne
     * @return \Illuminate\Http\Response
     */
    public function show(LicenceOne $licenceOne)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Students\LicenceOne  $licenceOne
     * @return \Illuminate\Http\Response
     */
    public function edit(LicenceOne $licenceOne)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Students\LicenceOne  $licenceOne
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LicenceOne $licenceOne)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Students\LicenceOne  $licenceOne
     * @return \Illuminate\Http\Response
     */
    public function destroy(LicenceOne $licenceOne)
    {
        //
    }

    public function createNewStudent($data)
    {
        $newStudent = new LicenceOne();
        $verif = LicenceOne::count();
        if ($verif > 0)
        {
            $preNum = LicenceOne::latest()->value('numInscrit');
            $arrayNum = explode("/", $preNum);
            $postNum = intval($arrayNum[0]);
            $postNum = $postNum + 1;
            $numInscrit = $postNum . '/' . $arrayNum[1] . '/' . $arrayNum[2] . '/' . $arrayNum[3];
        }
        else
        {
            $arrayYear = str_split($data['anneeUnivers']);
            $numInscrit = $arrayYear[2] . $arrayYear[3] . '0001' . '/' . 'L1' . '/SE' . '/' . 'D';
        }


    }
}
