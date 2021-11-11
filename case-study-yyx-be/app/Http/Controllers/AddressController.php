<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function create(Request $request) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'street1' => ['required', 'max:150'],
            'street2' => ['required', 'max:150'],
            'postcode' => ['required', 'max:5'],
            'state' => ['required'],
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        // Insert into db
        DB::table('addresses')->insert([
            'street1' => $request->input('street1'),
            'street2' => $request->input('street2'),
            'postcode' => $request->input('postcode'),
            'state' => $request->input('state'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'msg' => 'Successfully created address'
        ], Response::HTTP_OK);
    }

    public function edit(Request $request, $id) {
        // Validate data
        $validator = Validator::make($request->all(), [
            'street1' => ['required', 'max:150'],
            'street2' => ['required', 'max:150'],
            'postcode' => ['required', 'max:5'],
            'state' => ['required'],
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
        // update into db
        DB::table('addresses')->where('id', $id)->update([
            'street1' => $request->input('street1'),
            'street2' => $request->input('street2'),
            'postcode' => $request->input('postcode'),
            'state' => $request->input('state'),
            'updated_at' => now(),
        ]);

        $assignedEmployeesIds = explode(',', $request->input('employees'));
        $dataInsert = [];

        if($request->input('employees') != '') {
            for ($i=0; $i < count($assignedEmployeesIds); $i++) { 
                $dataInsert[] = [
                    'employee_id' => $assignedEmployeesIds[$i],
                    'address_id' => $id,
                ];
            }
    
            DB::table('address_employee')->where('address_id', $id)->delete();
            DB::table('address_employee')->insert($dataInsert);
        } else {
            DB::table('address_employee')->where('address_id', $id)->delete();
        }

        return response()->json([
            'msg' => 'Successfully edited address'
        ], Response::HTTP_OK);
    }

    public function delete($id) {
        // update into db
        DB::table('addresses')->where('id', $id)->update([
            'deleted' => true
        ]);

        return response()->json([
            'msg' => 'Successfully deleted address'
        ], Response::HTTP_OK);
    }

    public function getAll() {
        $addresses = Address::select('id', 'street1', 'street2', 'postcode', 'state')->with('employees')->where('deleted', 0)->orderBy('id', 'desc')->get();

        return response()->json([
            'addresses' => $addresses
        ], Response::HTTP_OK);
    }

    public function getOne($id) {
        $address = DB::table('addresses')->where('id', $id)->first();

        return response()->json([
            'address' => $address
        ], Response::HTTP_OK);
    }

    public function getAssignedEmployees($id) {
        $employeesIds = DB::table('address_employee')->where('address_id', $id)->pluck('employee_id')->toArray();

        return response()->json([
            'employeesIds' => $employeesIds
        ], Response::HTTP_OK);
    }
}
