<?php

namespace App\Http\Controllers\training;

use Controller, Auth, Carbon;
use Illuminate\Http\Request;
use App\Models\{Attendance,Trainee};
use App\Models\zkteco\{Personnel_trainee,Iclock_transaction};

class AttendanceController extends Controller
{
    public function ViewAttendances()
    {
        if ($this->CheckPermission('ManageTrainee') == true)
        {
            $Trainees = Trainee::all();
            $Attendances = Attendance::whereYear('punch_time',Carbon::now()->year)->whereMonth('punch_time',Carbon::now()->format('m'))->get();
            $Iclock_transactions = Iclock_transaction::whereYear('punch_time',Carbon::now()->year)->whereMonth('punch_time',Carbon::now()->format('m'))->get();

            if (empty($Attendances->last()->transaction_id)) {

                foreach ($Iclock_transactions as $Iclock_transaction) {
                    if (!empty($Iclock_transaction->emp_code)) {
                        if (!empty($Trainees->where('id',$Iclock_transaction->emp_code)->first())) {
                            $newAttendance = new Attendance();
                            $newAttendance -> punch_time = $Iclock_transaction->punch_time;
                            $newAttendance -> punch_state = $Iclock_transaction->punch_state;
                            $newAttendance -> terminal_sn = $Iclock_transaction->terminal_sn;
                            $newAttendance -> terminal_alias = $Iclock_transaction->terminal_alias;
                            $newAttendance -> trainee_id = $Iclock_transaction->emp_code;
                            $newAttendance -> transaction_id = $Iclock_transaction->id;
                            $newAttendance -> save();
                        }
                    }
                }

                $arr = array('Attendances' => Attendance::whereYear('punch_time',Carbon::now()->year)->whereMonth('punch_time',Carbon::now()->format('m'))->get() , 'Trainees' => $Trainees);

            }
            elseif ($Attendances->last()->transaction_id <= $Iclock_transactions->last()->id) {
                $count = Iclock_transaction::where('id','>', $Attendances->last()->transaction_id)->count();

                for ($i = 1 ; $i <= $count ; $i++) {
                    if (!empty($Iclock_transactions->find($Attendances->last()->transaction_id + $i)->emp_code)) {
                        if (!empty($Trainees->where('id',$Iclock_transactions->find($Attendances->last()->transaction_id + $i)->emp_code)->first())) {
                            $newAttendance = new Attendance();
                            $newAttendance -> punch_time = $Iclock_transactions->find($Attendances->last()->transaction_id + $i)->punch_time;
                            $newAttendance -> punch_state = $Iclock_transactions->find($Attendances->last()->transaction_id + $i)->punch_state;
                            $newAttendance -> terminal_sn = $Iclock_transactions->find($Attendances->last()->transaction_id + $i)->terminal_sn;
                            $newAttendance -> terminal_alias = $Iclock_transactions->find($Attendances->last()->transaction_id + $i)->terminal_alias;
                            $newAttendance -> trainee_id = $Iclock_transactions->find($Attendances->last()->transaction_id + $i)->emp_code;
                            $newAttendance -> transaction_id = $Iclock_transactions->find($Attendances->last()->transaction_id + $i)->id;
                            $newAttendance -> save();
                        }
                    }
                }

                $arr = array('Attendances' => Attendance::whereYear('punch_time',Carbon::now()->year)->whereMonth('punch_time',Carbon::now()->format('m'))->get() , 'Trainees' => $Trainees);
            }
            else
            {
                $arr = array('Attendances' => $Attendances , 'Trainees' => $Trainees);
            }
            return view('training/Attendances',$arr);
        }
        else
        {
            return view('errors/AccessDenied');
        }
    }

    public function SearchTraineeAttendance(Request $Request)
    {
        if ($this->CheckPermission('ManageTrainee') == true)
        {
            $Attendances = Attendance::where('trainee_id',$Request->trainee_id)->whereBetween('punch_time', [$Request->start_date , $Request->end_date])->get();
            $response = array();
            foreach($Attendances as $Attendance){
            $response[] = array("id"=>$Attendance->id,
                                "trainee_name"=>$Attendance->trainee->first_name." ".$Attendance->trainee->middle_name." ".$Attendance->trainee->last_name,
                                "department"=>$Attendance->trainee->position->department->name,
                                "punch_time"=>$Attendance->punch_time,
                                "punch_state_hidden"=>$Attendance->punch_state,
                                "punch_state" =>[
                                    "id"=>$Attendance->id,
                                    "state"=>$Attendance->punch_state
                                ],
                                "terminal_sn" =>$Attendance->terminal_sn,
                                "terminal_alias"=>$Attendance->terminal_alias,
                                "modify" =>[
                                    "id"=>$Attendance->id,
                                    "sync"=>$Attendance->sync]);
            }

            return response()->json($response);
        }
        else
        {
            return view('errors/AccessDenied');
        }
    }

    public function ChangeAttendanceSync(Request $Request)
    {
        if ($this->CheckPermission('EditEmp') == true)
        {
            $sync = Attendance::find($Request->AttendanceID);

                if ($sync->sync == 1) {
                    $sync -> sync = 0;
                    $sync -> save();
                    return response()->json("fail");
                } else{
                    $sync -> sync = 1;
                    $sync -> save();
                    return response()->json("pass");
                }
        }
        else
        {
            return response()->json("Access Denied");
        }
    }

    public function ChangePunchState(Request $Request)
    {
        if ($this->CheckPermission('EditEmp') == true)
        {
            $PunchState = Attendance::find($Request->AttendanceID);

                if ($Request->PunchState == 0) {
                    $PunchState -> punch_state = 0;
                    $PunchState -> save();
                    return response()->json("Check IN");
                }
                else if ($Request->PunchState == 1) {
                    $PunchState -> punch_state = 1;
                    $PunchState -> save();
                    return response()->json("Check Out");
                }
        }
        else
        {
            return response()->json("Access Denied");
        }
    }
}
