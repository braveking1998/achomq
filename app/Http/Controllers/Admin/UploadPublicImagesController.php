<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class UploadPublicImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/GameSetting/Images/Index', [
            'images' => ProfileImage::where('type', 'public')->get(),
        ]);
    }

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
                'type' => 'public',
            ]);
        }

        return redirect()->back()->with('success', 'تصویر با موفقیت آپلود شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfileImage $image)
    {
        if ($image->id === 1) {
            throw ValidationException::withMessages(['message' => 'شما نمی توانید این پروفایل را حذف کنید.']);
            return redirect()->back();
        }
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
