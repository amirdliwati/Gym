<?php

namespace App\Http\Controllers\training;

use Controller, Auth, Hash, Storage;
use Illuminate\Http\Request;
use App\Models\{User,Department,Position,Trainee,Role,Addresse,Phone,Emergencie,Countrie,Membership,Employee,State};

class TraineesController extends Controller
{
///////////////////////////////////////////// Add Trainee ////////////////////////////////////////////
    public function AddTrainee(Request $Request)
    {
        if ($this->CheckPermission('AddTrainee') == true) {
            if ($Request->isMethod('post')) {
                $Email = Trainee::where('system_email',$Request->input('system_email'))->first();
                if (empty($Email)) {
                    $newTrainee = new Trainee();
                    $newTrainee -> prefix = $Request->input('prefix');
                    $newTrainee -> first_name = $Request->input('first_name');
                    $newTrainee -> middle_name = $Request->input('middle_name');
                    $newTrainee -> last_name = $Request->input('last_name');
                    $newTrainee -> birthdate = $Request->input('birthdate');
                    $newTrainee -> gender = $Request->input('gender');  //female=1, male=2
                    $newTrainee -> marital_status = $Request->input('marital_status');  //sin=1,mar=2,div=3,wid=4
                    $newTrainee -> country_id = $Request->input('Nationality');
                    $newTrainee -> national_no = $Request->input('national_no');
                    $newTrainee -> passport = $Request->input('passport');
                    $newTrainee -> email = $Request->input('email');
                    $newTrainee -> system_email = $Request->input('system_email');
                    $newTrainee -> position_id = 54;
                    $newTrainee -> membership_id = $Request->input('membership_id');
                    $newTrainee -> department_id = $Request->input('department_id');
                    $newTrainee -> status = 1;
                    $newTrainee -> save();

                    if ($Request->hasFile('trainee_image')) {
                        $file = $Request->file('trainee_image');
                        $filename ='ProfilePic_'. $newTrainee->id . '.' . $Request->file('trainee_image')->guessClientExtension();
                        Storage::disk('trainee')->putFileAs("/".$newTrainee->id . '_' . $newTrainee->first_name, $file, $filename);
                        $newTrainee -> image = 'uploads/Trainees/' . $newTrainee->id . '_' . $newTrainee->first_name . '/' . $filename;
                        $newTrainee -> save();
                    }

                    $newUser = new User();
                    $newUser -> trainee_id = $newTrainee->id;
                    $newUser -> name =  $newTrainee->first_name . ' ' . $newTrainee->last_name;
                    $newUser -> email = $newTrainee->system_email;
                    $newUser -> password =  Hash::make($newTrainee->system_email);
                    $newUser -> status  = 1;
                    $newUser -> save();

                    $newRole = new Role();
                    $newRole -> title = 'Trainee_role';
                    $newRole -> active = 1;
                    $newRole -> content = 'Custom Role for Trainee';
                    $newRole -> usr_id = $newUser->id;
                    $newRole -> save();

                    $this->addPermAddress($Request, $newTrainee->id);
                    $this->addTempAddress($Request, $newTrainee->id);
                    $this->addPhone($Request, $newTrainee->id);
                    $this->addEmergency($Request, $newTrainee->id);

                    $this->AddToLog('New Trainee Added', $newTrainee->id , $newTrainee->first_name . ' ' . $newTrainee->last_name);

                    return response()->json($newTrainee->id);
                }else {
                    return response()->json('Email Error');
                }
            }else {
                $Countries = Countrie::where('status',1)->get();
                $departments = Department::where('name','Training')->get();
                $Memberships = Membership::all();
                $arr = array('Countries' => $Countries, 'departments' => $departments, 'Memberships' => $Memberships);

                return view('training/AddTrainee',$arr);
            }
        }else {
            return view('errors/AccessDenied');
        }
    }

////////////////////////////////////////// Trainee Profile ////////////////////////////////////////
    public function TraineeProfile(Request $Request)
    {
        if ($this->CheckPermission('ViewTrainee') == true) {
            if (!empty(Auth::user()->roles->whereIn('title',['Admin_role','Training_role'])->first())) {
                $Trainee = Trainee::where('id',$Request->id)->first();
            }else {
                return view('errors/AccessDenied');
            }

            $arr = array('Trainee' => $Trainee);
            return view('training/TraineeProfile',$arr);
        }
        else {
            return view('errors/AccessDenied');
        }
    }

/////////////////////////////////////////////// All Trainees ///////////////////////////////////////////
    public function ViewTrainees()
    {
        if ($this->CheckPermission('ManageTrainee') == true)
        {

            $Users = User::join('trainees','trainees.id','=','users.trainee_id')->whereIn('trainees.status',[1,2])->select('users.*')->get();

            $arr = array('Users' => $Users);
            return view('training/Trainees',$arr);
        }
        else
        {
            return view('errors/AccessDenied');
        }
    }

    public function ChangeStatusTrainee(Request $Request)
    {
        if ($this->CheckPermission('EditTrainee') == true)
        {
            $EditTrainee = Trainee::find($Request->input('trainee_id'));
            $EditTrainee -> status = $Request->input('status');
            $EditTrainee -> save();
        }
        else
        {
            return view('errors/404');
        }
    }

//////////////////////////////////// Edit Trainee ////////////////////////////////////////////////
    public function EditTrainee(Request $Request)
    {
        if ($this->CheckPermission('EditTrainee') == true)
        {
            if ($Request->isMethod('post'))
            {
                $EditTrainee = Trainee::find($Request->input('Trainee_id'));
                $EditTrainee -> prefix = $Request->input('prefix');
                $EditTrainee -> first_name = $Request->input('first_name');
                $EditTrainee -> middle_name = $Request->input('middle_name');
                $EditTrainee -> last_name = $Request->input('last_name');
                $EditTrainee -> birthdate = $Request->input('birthdate');
                $EditTrainee -> gender = $Request->input('gender');  //female=1, male=2
                $EditTrainee -> marital_status = $Request->input('marital_status');  //sin=1,mar=2,div=3,wid=4
                $EditTrainee -> country_id = $Request->input('Nationality');
                $EditTrainee -> national_no = $Request->input('national_no');
                $EditTrainee -> passport = $Request->input('passport');
                $EditTrainee -> email = $Request->input('email');
                $EditTrainee -> membership_id = $Request->input('membership_id');
                $EditTrainee -> department_id = $Request->input('department_id');
                $EditTrainee -> save();

                if ($Request->hasFile('trainee_image'))
                {
                    $file = $Request->file('trainee_image');
                    $filename ='ProfilePic_'. $EditTrainee->id . '.' . $Request->file('trainee_image')->guessClientExtension();
                    Storage::disk('Employees')->putFileAs("/".$EditTrainee->id . '_' . $EditTrainee->first_name, $file, $filename);
                    $EditTrainee -> trainee_image = 'uploads/Trainees/' . $EditTrainee->id . '_' . $EditTrainee->first_name . '/' . $filename;
                    $EditTrainee -> save();
                }

                //Address //Perm
                if ($EditTrainee->addresses->where('add_type',1)->count() <= 0)
                {
                    $this->addPermAddress($Request, $EditTrainee->id);
                }
                else
                {
                    $this->editPermAddress($Request);
                }
                //Address //Temp
                if ($EditTrainee->addresses->where('add_type',2)->count() <= 0)
                {
                    $this->addTempAddress($Request, $EditTrainee->id);
                }
                else
                {
                    $this->editTempAddress($Request);
                }

                //Phone
                if ($EditTrainee->phones->count() <= 0)
                {
                    $this->addPhone($Request);
                }
                else
                {
                    Phone::where('trainee_id',$EditTrainee->id)->delete();
                    $this->addPhone($Request, $EditTrainee->id);
                }
                //Emergency
                if ($EditTrainee->emergencies->count() <= 0)
                {
                    $this->addEmergency($Request, $EditTrainee->id);
                }
                else
                {
                    $this->editEmergency($Request);
                }

                $this->AddToLog('Trainee Modified', $EditTrainee->id , $EditTrainee->first_name . ' ' . $EditTrainee->last_name);

                return response()->json($Request->Trainee_id);
            }
            else
            {
                $Countries = Countrie::where('status',1)->get();
                $departments = Department::where('name','Training')->get();
                $Memberships = Membership::all();
                $Trainee = Trainee::find($Request->TraineeID);
                $arr = array('Trainee' => $Trainee, 'Countries' => $Countries, 'departments' => $departments, 'Memberships' => $Memberships);

                return view('training/EditTrainee',$arr);
            }
        }
        else
        {
            return view('errors/AccessDenied');
        }
    }

////////////////////////////////////////////////// Address ///////////////////////////////////
    public function addPermAddress($Request,$trainee_id)
    {
        //Address Permenant
        if ($Request->input('address') != "")
        {
            $NewAddress = new Addresse();
            $NewAddress -> add_type = 1;
            $NewAddress -> address = $Request->input('address');
            $NewAddress -> country_id = $Request->input('country');
            $NewAddress -> state_id = $Request->input('state');
            $NewAddress -> trainee_id = $trainee_id;
            $NewAddress -> save();
        }
    }

    public function editPermAddress($Request)
    {
        //Address Permenant
        $EditAddress = Addresse::where('trainee_id',$Request->input('Trainee_id'))->where('add_type',1)->first();
        if ($Request->input('address') != "")
        {
            $EditAddress -> address = $Request->input('address');
            $EditAddress -> country_id = $Request->input('country');
            $EditAddress -> state_id = $Request->input('state');
            $EditAddress -> save();
        }
        else
        {
            $EditAddress -> delete();
        }
    }

    public function addTempAddress($Request,$trainee_id)
    {
        //Address Temporary
        if ($Request->input('address2') != "")
        {
            $NewAddress = new Addresse();
            $NewAddress -> add_type = 2;
            $NewAddress -> address = $Request->input('address2');
            $NewAddress -> country_id = $Request->input('country2');
            $NewAddress -> state_id = $Request->input('state2');
            $NewAddress -> trainee_id = $trainee_id;
            $NewAddress -> save();
        }
    }

    public function editTempAddress($Request)
    {
        //Address Temporary
        $EditAddress = Addresse::where('trainee_id',$trainee_id)->where('add_type',2)->first();
        if ($Request->input('address2') != "")
        {
            $EditAddress -> address = $Request->input('address2');
            $EditAddress -> country_id = $Request->input('country2');
            $EditAddress -> state_id = $Request->input('state2');
            $EditAddress -> save();
        }
        else
        {
            $EditAddress -> delete();
        }
    }

/////////////////////////////////// Phones ////////////////////////////////////////////
    public function addPhone($Request,$trainee_id)
    {
        //Phone
        for ($i=0; $i < $Request->input('count_phone') ; $i++)
        {
            $NewPhone = new Phone();
            $NewPhone -> phone_type = $Request->phones[$i]['phone_type'];
            $NewPhone -> number = $Request->phones[$i]['number'];
            $NewPhone -> trainee_id = $trainee_id;
            $NewPhone -> save();
        }
    }

/////////////////////////////////////// Emergency //////////////////////////////////////////
    public function addEmergency($Request,$trainee_id)
    {
        //Emergency
        $newEmergencie = new Emergencie();
        $newEmergencie -> fname_emer = $Request->input('fname_emer');
        $newEmergencie -> lname_emer = $Request->input('lname_emer');
        $newEmergencie -> relationship = $Request->input('relationship');
        $newEmergencie -> house_phone = $Request->input('house_phone');
        $newEmergencie -> mobile_phone = $Request->input('mobile_phone');
        $newEmergencie -> trainee_id = $trainee_id;
        $newEmergencie -> save();
    }

    public function editEmergency($Request)
    {
        //Emergency
        $editEmergencie = Emergencie::where('trainee_id',$Request->input('Trainee_id'))->first();
        $editEmergencie -> fname_emer = $Request->input('fname_emer');
        $editEmergencie -> lname_emer = $Request->input('lname_emer');
        $editEmergencie -> relationship = $Request->input('relationship');
        $editEmergencie -> house_phone = $Request->input('house_phone');
        $editEmergencie -> mobile_phone = $Request->input('mobile_phone');
        $editEmergencie -> save();
    }

///////////////////////// To Feed Ajax //////////////////////////////////////////
    public function getStateList(Request $Request)
    {
        $states = State::where("country_id",$Request->country_id)->pluck("name","id");
        return response()->json($states);
    }

}
