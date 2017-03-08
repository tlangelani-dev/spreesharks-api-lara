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

    public function store()
    {
        return 'STORE';
    }
}
