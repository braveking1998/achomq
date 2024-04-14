<?php

namespace App\Http\Controllers;

use App\Models\ProfileImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UploadPrivateImagesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Via system
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $validate = $request->validate([
                'image' => 'required|mimes:png,webp|max:2048|dimensions:width=512,height=512',
            ]);

            $path = $image->store('images', 'public');

            $request->user()->profileImages()->create([
                'file_path' => $path,
                'type' => 'private',
            ]);
        }

        return redirect()->back()->with('success', 'تصویر با موفقیت آپلود شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfileImage $image)
    {
        Gate::allowIf(function (User $user) use ($image) {
            return $user->id === $image->user_id;
        });

        // Set user's profile image to null
        User::where('profile_image', $image->id)->update([
            'profile_image' => 1,
        ]);

        // Delete from the disk
        Storage::disk('public')->delete($image->file_path);
        // Delete from the database
        $image->delete();

        return redirect()->back()->with('success', 'تصویر با موفقیت حذف شد.');
    }
}
