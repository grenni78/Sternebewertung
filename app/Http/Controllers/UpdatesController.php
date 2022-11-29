<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdatesController extends Controller
{
    //
    /**
     * get list of Updates
     */
    public function api_get_updates(Request $response)
    {
        $user_id = Auth::user()->id;

        $user = \App\Models\User::find($user_id);

        $user->unreadNotifications->markAsRead();

        return response()->json($user->unreadNotifications);

    }
}
