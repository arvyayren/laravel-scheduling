<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

use App\Models\DailyRecord;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            $users = User::query();
            return DataTables::of($users)->editColumn('Name', function(User $user) {
                $name = json_decode($user->Name);
                return $name->title.' '.$name->first.' '.$name->last;
            })
            ->addIndexColumn()
            ->addColumn('action', function (User $users){
                $actionBtn = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" title="Delete" onclick="del('.$users->id.')" ><i class="fas fa-trash "></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }

        return view('datatable');
    }

    public function report(){
        if (request()->ajax()) {
            $report = DailyRecord::query();
            return DataTables::of($report)
            ->make();
        }

        return view('report.datatable');
    }

    public function delete($id){
        DB::beginTransaction();

        try{
            $user = User::find($id);

            if(isset($user)){
                $date = date("Y-m-d", strtotime($user->created_at));

                $daily_record = DailyRecord::whereDate('date', '=', $date)->first();

                switch($user->Gender){
                    case 'male':
                        $daily_record->male_count = $daily_record->male_count-1;
                        $daily_record->save();
                        break;
                    case 'female':
                        $daily_record->female_count = $daily_record->female_count-1;
                        $daily_record->save();
                        break;
                }

                $user->delete();
            }

            DB::commit();

            $response = array(
                'code' => 200,
                'data' => [],
                'message' => 'Data success delete'
            );

            return response()->json($response);
        }catch(\Exception $e){
            DB::rollback();

            $response = array(
                'code' => 200,
                'data' => [],
                'message' => 'Data failed delete'
            );

            return response()->json($response);
        }
    }
}
