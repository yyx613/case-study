<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\Undefined;

class EmployeeController extends Controller
{
    public function create(Request $request) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:employees'],
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
        // Insert into db
        DB::table('employees')->insert([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'msg' => 'Successfully created employee'
        ], Response::HTTP_OK);
    }

    public function edit(Request $request, $id) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
        // update into db
        DB::table('employees')->where('id', $id)->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'updated_at' => now(),
        ]);

        $assignedAddressesIds = explode(',', $request->input('addresses'));
        $dataInsert = [];

        if($request->input('addresses') != '') {
            for ($i=0; $i < count($assignedAddressesIds); $i++) { 
                $dataInsert[] = [
                    'employee_id' => $id,
                    'address_id' => $assignedAddressesIds[$i],
                ];
            }
    
            DB::table('address_employee')->where('employee_id', $id)->delete();
            DB::table('address_employee')->insert($dataInsert);
        } else {
            DB::table('address_employee')->where('employee_id', $id)->delete();
        }

        return response()->json([
            'msg' => 'Successfully edited employee'
        ], Response::HTTP_OK);
    }

    public function delete($id) {
        // update into db
        DB::table('employees')->where('id', $id)->update([
            'deleted' => true
        ]);

        return response()->json([
            'msg' => 'Successfully deleted employee'
        ], Response::HTTP_OK);
    }

    public function getAll($filterKeyword) {
        $employees = Employee::select('id', 'first_name', 'last_name', 'email', 'deleted')
                    ->with(['addresses', 'roles'])
                    ->where('deleted', 0)
                    ->orderBy('id', 'desc');

        if($filterKeyword != 'null') {
            $employees = $employees->whereHas('addresses', function ($q) use ($filterKeyword) {
                $q->where( function ($q) use ($filterKeyword) {
                    $q->orWhere('street1','LIKE', '%'.$filterKeyword.'%')
                        ->orWhere('street2','LIKE', '%'.$filterKeyword.'%')
                        ->orWhere('postcode', 'like', '%'.$filterKeyword.'%')
                        ->orWhere('state', 'like', '%'.$filterKeyword.'%');
                });

            });
        }

        $employees = $employees->get();

        return response()->json([
            'employees' => $employees
        ], Response::HTTP_OK);
    }

    public function getAllDeleted() {
        $employees = Employee::select('id', 'first_name', 'last_name', 'email', 'deleted')
                    ->with('addresses')
                    ->where('deleted', 1)
                    ->orderBy('id', 'desc')
                    ->get();

        return response()->json([
            'employees' => $employees
        ], Response::HTTP_OK);
    }

    public function getOne($id) {
        $employee = DB::table('employees')->where('id', $id)->first();

        return response()->json([
            'employee' => $employee
        ], Response::HTTP_OK);
    }

    public function getAssignedAddresses($id) {
        $addressesIds = DB::table('address_employee')->where('employee_id', $id)->pluck('address_id')->toArray();

        return response()->json([
            'addressesIds' => $addressesIds
        ], Response::HTTP_OK);
    }
}
