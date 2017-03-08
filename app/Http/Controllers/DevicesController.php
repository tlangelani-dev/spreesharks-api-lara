<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function registered()
    {
        $device = Device::orderBy('id', 'desc')->get();
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

    public function push(Request $request) {
        $all = $request->all();
        $token = $all['token'];
        $sku = $all['sku'];
        die('DYING FOR NOW...');
        // Put your device token here (without spaces):
        // $deviceToken = 'ad648e26c765d78bad945eaf7eed7b192ffe6ed47fbfcfe973a11e7ed96931f2';
        $deviceToken = $all['deviceToken'];

        // Put your private key's passphrase here:
        $passphrase = 'spreesharks';

        $url = 'https://api-dev.spreeza.net/cart/';
        $message = 'Spree Sharks App';

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ApplePushCert.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client(
        'ssl://gateway.sandbox.push.apple.com:2195', $err,
        $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp) {
            // exit("Failed to connect: $err $errstr" . PHP_EOL);
            return response()->json(["Failed to connect: $err $errstr"]);
        }

        // echo 'Connected to APNS' . PHP_EOL;

        // Create the payload body
        $body['aps'] = array(
            'alert' => $message,
            'sound' => 'default',
            'link_url' => $url,
        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        fclose($fp);

        if (!$result) {
            return response()->json(['Message not delivered']);
            // echo 'Message not delivered';
        } else {
            return response()->json(['Message successfully delivered']);
            // echo 'Message successfully delivered';
        }
    }
}
