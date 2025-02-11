<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Allow customizing items per page
        $feedbacks = Feedback::orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString(); // Preserve other query parameters
        
        return view('admins.feedback.index', compact('feedbacks'));
    }

    public function show(Feedback $feedback)
    {
        return view('admins.feedback.show', compact('feedback'));
    }

    public function updateStatus(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,replied'
        ]);

        $feedback->update($validated);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
    }

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

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Xóa phản hồi thành công');
    }
} 