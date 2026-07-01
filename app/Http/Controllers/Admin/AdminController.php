<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\Students\LicenceOne;
use App\Models\Students\LicenceThree;
use App\Models\Students\LicenceTwo;
use App\Models\Students\MasterOne;
use App\Models\Students\MasterRecherche;
use App\Models\Students\MasterTwo;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public $search;

    public function index()
    {
        $countL1 = LicenceOne::all()->count();
        $countL2 = LicenceTwo::all()->count();
        $countL3 = LicenceThree::all()->count();

        $countM1 = MasterOne::all()->count();
        $countM2 = MasterTwo::all()->count();
        $countMR = MasterRecherche::all()->count();

        $users = User::where('name', 'LIKE', "%{$this->search}%")
        ->orWhere('prenom', 'LIKE', "%{$this->search}%")
        ->get();;
        return view('admin.home', [
            'users'=> $users,
            'L1'=> $countL1,
            'L2'=> $countL2,
            'L3'=> $countL3,
            'M1'=> $countM1,
            'M2'=> $countM2,
            'MR'=> $countMR,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request)
    {
        $input = $request->all();
        (new CreateNewUser)->create($input);
        return redirect('admin/admin')->with('message', "Ajouter avec succés");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function search(Request $request)
    {
        $this->search = $request->search;
        return redirect('admin/admin');
    }

    public function changeStatus($id)
    {
        $user = User::find($id);
        if ($user->status == 1){
            $user->status = 0;
            $user->save();
        } else{
            $user->status = 1;
            $user->save();
        }
        return redirect()->back();
    }
}
