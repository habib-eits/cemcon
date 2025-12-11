<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SubService;
use App\Models\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function ajaxGetAgents($id = null)
    {
        try {
            if ($id != null) {
                $agents = User::where('role', '!=', 'Admin')
                    ->where('branch_id', $id)
                    ->get();
            } else {
                $agents = User::where('role', '!=', 'Admin')
                    ->get();
            }
            return response()->json(['data' => $agents]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function ajaxGetServices($id = null)
    {
        try {
            if ($id != null) {
                $services = Service::where('branch_id', $id)
                    ->get();
            } else {
                $services = Service::all();
            }
            return response()->json(['data' => $services]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function ajaxGetSubservices($id = null)
    {
        try {
            if ($id != null) {
                $subServices = SubService::where('service_id', $id)
                    ->get();
            } else {
                $subServices = SubService::all();
            }
            return response()->json(['data' => $subServices]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
