<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function getnotifications()
    {

        return auth()->user()->notifications;
    }
    public function unreadnotifications()
    {

        return auth()->user()->unreadnotifications;
    }

    public function markreadnotifications()
    {

        auth()->user()->unreadNotifications->markAsRead();
        return  auth()->user()->notifications;
    }

    public function marksinglenotification($id)
    {

        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        return auth()->user()->notifications;
    }


    public function destroy()
    {
        auth()->user()->notifications()->delete();
        return response()->json('cleared');
    }
}
