<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $userOrders = Order::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->paginate(5);

        return view('profile', [
            'user' => $request->user(),
            'userOrders' => $userOrders,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * For User Order Detail
     */
    public function userOrderDetail($id)
    {
        $orderProducts = Order::with('orderProducts')->findOrFail($id);

        return view('order-info', compact('orderProducts'));
    }

    /**
     * For Show Order Status
     */
    public function trackOrder($id)
    {
        $order = Order::with('orderProducts')->findOrFail($id);

        return view('order-tracking', compact('order'));
    }

    /**
     * For Redirect to return order page
     */
    public function returnOrder($id)
    {
        $order = Order::with('orderProducts')->findOrFail($id);

        return view('return-order', compact('order'));
    }
}
