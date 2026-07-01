<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushSubscriptionController extends Controller
{
    /**
     * Store the Push Subscription.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'endpoint'    => 'required|url',
            'keys.auth'   => 'required|string',
            'keys.p256dh' => 'required|string'
        ]);

        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();

        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true]);
    }
}
