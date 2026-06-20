<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Destinasi;
use App\Models\SavedPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $savedPlacesCount = SavedPlan::where('user_id', $user->id)->count();
        $totalDestinations = Destinasi::count();

        $travelScore = min(100, 50 + ($savedPlacesCount * 10));

        return view('profile.edit', [
            'user' => $user,
            'savedPlacesCount' => $savedPlacesCount,
            'totalDestinations' => $totalDestinations,
            'travelScore' => $travelScore,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('profile_photo')) {
            if ($request->user()->profile_photo) {
                Storage::disk('public')->delete($request->user()->profile_photo);
            }

            $validated['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()
            ->route('profile.edit')
            ->with('status', 'profile-updated');
    }
    public function destroyPhoto(Request $request)
    {
        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);

            $user->update([
                'profile_photo' => null,
            ]);
        }

        return redirect()
            ->route('profile.edit')
            ->with('status', 'profile-photo-deleted');
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
}