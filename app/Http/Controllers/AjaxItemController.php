<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AjaxItemController extends Controller
{
    public function store(Request $request)
    {
        // Permission check
        $allow = check_role(Session::get('UserID'), 'Item/Inventory', 'List / Create');
        if ($allow == 0) {
             return response()->json(['status' => 'error', 'message' => 'You access is limited']);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'ItemName' => 'required',
            // 'Unit' => 'required',
            // 'SellingPrice' => 'required',
            // 'CostPrice' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        try {
            $data = array(
                // 'ItemType' => $request->ItemType, 
                // 'ItemCode' => $request->ItemCode,
                'ItemName' => $request->ItemName,
                // 'UnitName' => $request->Unit,
                'UnitQty' => $request->UnitQty,
                'CostPrice' => $request->CostPrice,
                'SellingPrice' => $request->SellingPrice,
                // Add default values for other fields if necessary or let them be null
            );

            $id = DB::table('item')->insertGetId($data);
            
            // Fetch the inserted item to return it
            $newItem = DB::table('item')->where('ItemID', $id)->first();

            return response()->json([
                'status' => 'success',
                'message' => 'Item saved successfully',
                'item' => $newItem
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
}
