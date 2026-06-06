<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        
        $notification->markAsRead();
        
        if (isset($notification->data['url'])) {
            return redirect($notification->data['url']);
        }
        
        return back();
    }
}
