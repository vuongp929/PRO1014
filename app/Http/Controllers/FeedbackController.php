<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string'
        ]);

        $feedback = new Feedback($validated);
        
        if (Auth::check()) {
            $feedback->user_id = Auth::id();
        }
        
        $feedback->save();

        return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi phản hồi cho chúng tôi!');
    }
} 