<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function registered()
    {
        $device = Device::all();
        return response()->json($device);
    }

    public function store(Request $request)
    {
        $all = $request->all();
        $device = new Device;
        $device->email = $all['email'];
        $device->token = $all['token'];
        $result = $device->save();
        return response()->json($result);
    }
}
