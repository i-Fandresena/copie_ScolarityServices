<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('auth');

    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */

    public function index()

    {
        $L1 = DB::table('licence_ones')->count();
        $L2 = DB::table('licence_twos')->count();
        $L3 = DB::table('licence_threes')->count();
        $M1 = DB::table('master_ones')->count();
        $M2 = DB::table('master_twos')->count();
        return view('auth.profile')
                ->with('l1',$L1)
                ->with('l2',$L2)
                ->with('l3',$L3)
                ->with('m1',$M1)
                ->with('m2',$M2);
    }



    /**

     * Write code on Method

     *

     * @return \Illuminate\Http\RedirectResponse()

     */

    public function store(Request $request)

    {

        $request->validate([

            'images' => 'required|image',

        ]);



        $avatarName = Auth::user()->name.'.'.$request->images->getClientOriginalExtension();

        $request->images->move(public_path('storage'), $avatarName);



        Auth()->user()->update(['images'=>$avatarName]);



        return back()->with('success', 'Votre profile a étè mis à jours.');

    }
}
