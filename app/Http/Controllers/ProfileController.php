<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;




class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Log::info('Current user:', ['user' => $request->user()]);

        $user = $request->user();

        if (!$user instanceof User) {
            abort(403, 'Unauthorized action.');
        }

        $user->fill($request->validated());

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
{
    $request->validateWithBag('userDeletion', [
        'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    Auth::logout();

    // Xóa giỏ hàng khỏi session khi người dùng đăng xuất
    $request->session()->forget('cart');

    // Xóa người dùng và thông tin session
    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
}

    public function verify(Request $request)
    {
        $user = $request->user(); // Lấy người dùng hiện tại

        // Kiểm tra xem email đã được xác minh chưa
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('success', 'Email của bạn đã được xác minh!');
        }

        // Nếu chưa, xác minh email
        if ($user->markEmailAsVerified()) {
            // Bạn có thể trigger sự kiện xác minh nếu cần
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        return redirect()->route('dashboard')->with('success', 'Email xác minh thành công!');
    }

    public function resendVerificationEmail()
    {
        $user = Auth::user();  // Lấy người dùng hiện tại

        if ($user->hasVerifiedEmail()) {
            // Người dùng đã xác minh email
            return redirect()->route('dashboard');
        }

        $user->sendEmailVerificationNotification();  // Gửi lại email xác minh
        return back()->with('status', 'verification-link-sent');

    }

}
