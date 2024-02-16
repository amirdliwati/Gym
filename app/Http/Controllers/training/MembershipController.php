<?php

namespace App\Http\Controllers\training;

use Controller, Auth;
use Illuminate\Http\Request;
use App\Models\{Membership};

class MembershipController extends Controller
{
	public function Memberships(Request $Request)
    {
        if ($this->CheckPermission('MembershipManage') == true)
        {
            if ($Request->isMethod('post'))
            {
                $newMembership = new Membership();
                $newMembership -> name = $Request->input('name');
                $newMembership -> description = $Request->input('description');
                $newMembership -> save();

                $this->AddToLog('Added Membership',$newMembership->name , $newMembership->id);
                $Request->session()->put('msgSuccess', 'Membership has been added successfully');
            }
            else
            {
                $Memberships = Membership::all();
                $arr = array('Memberships' => $Memberships);
                return view('training/Memberships',$arr);
            }
        }
        else
        {
            return view('errors/AccessDenied');
        }
    }
}
