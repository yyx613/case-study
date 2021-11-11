<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function create(Request $request) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:150'],
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        // Insert into db
        DB::table('roles')->insert([
            'title' => $request->input('title'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'msg' => 'Successfully created role'
        ], Response::HTTP_OK);
    }

    public function edit(Request $request, $id) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:150'],
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
        // update into db
        DB::table('roles')->where('id', $id)->update([
            'title' => $request->input('title'),
            'updated_at' => now(),
        ]);

        $assignedEmployeesIds = explode(',', $request->input('employees'));
        $dataInsert = [];

        if($request->input('employees') != '') {
            for ($i=0; $i < count($assignedEmployeesIds); $i++) { 
                $dataInsert[] = [
                    'employee_id' => $assignedEmployeesIds[$i],
                    'role_id' => $id,
                ];
            }
    
            DB::table('employee_role')->where('role_id', $id)->delete();
            DB::table('employee_role')->insert($dataInsert);
        } else {
            DB::table('employee_role')->where('role_id', $id)->delete();
        }

        return response()->json([
            'msg' => 'Successfully edited role'
        ], Response::HTTP_OK);
    }

    public function delete($id) {
        // update into db
        DB::table('roles')->where('id', $id)->update([
            'deleted' => true
        ]);

        return response()->json([
            'msg' => 'Successfully deleted role'
        ], Response::HTTP_OK);
    }

    public function getAll() {
        $roles = Role::select('id', 'title')->with('employees')->where('deleted', 0)->orderBy('id', 'desc')->get();

        return response()->json([
            'roles' => $roles
        ], Response::HTTP_OK);
    }

    public function getOne($id) {
        $role = DB::table('roles')->where('id', $id)->first();

        return response()->json([
            'role' => $role
        ], Response::HTTP_OK);
    }

    public function getAssignedEmployees($id) {
        $employeesIds = DB::table('employee_role')->where('role_id', $id)->pluck('employee_id')->toArray();

        return response()->json([
            'employeesIds' => $employeesIds
        ], Response::HTTP_OK);
    }
}
