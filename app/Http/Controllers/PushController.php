<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store the PushSubscription.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pushSubscription.endpoint' => 'required',
            'pushSubscription.keys.auth' => 'required',
            'pushSubscription.keys.p256dh' => 'required',
        ]);
        $endpoint = $request->pushSubscription["endpoint"];
        $token = $request->pushSubscription["keys"]['auth'];
        $key = $request->pushSubscription["keys"]['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true], 200);
    }
    /**
     * deletes the PushSubscription.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'pushSubscription.endpoint' => 'required',
        ]);
        $endpoint = $request->pushSubscription["endpoint"];

        $user = Auth::user();
        $user->deletePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true], 200);
    }
}
