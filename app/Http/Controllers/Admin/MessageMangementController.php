<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\message;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Models\ProfileImage;
use App\Notifications\AdminMessage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\DatabaseNotification;

class MessageMangementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Messages/Index', [
            'messages' => Message::mostRecent()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Messages/Create', [
            'users' => User::all(['id', 'name'])->except(1),
            'images' => ProfileImage::where('type', 'public')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'selectedUsers' => 'required',
            'title' => 'required|string|min:3|max:110',
            'text' => 'required|string',
            'image' => 'required'
        ]);

        // All users
        if (in_array("all", $request->selectedUsers)) {
            $users = User::all();
        } else {
            $users = User::find($request->selectedUsers);
        }

        $message = Message::create([
            'title' => $request->title,
            'image' => $request->image,
            'text' => $request->text,
            'users' => $request->selectedUsers,
        ]);

        Notification::send($users, new AdminMessage(['id' => $message->id, 'title' => $request->title, 'image' => $request->image, 'text' => $request->text]));

        // Specific users
        return redirect()->back()->with('success', 'در خواست شما با موفقیت انجام شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        $users = $message['users'];
        if (in_array('all', $message['users'])) {
            $all = 'all';
        }
        return Inertia::render('Admin/Messages/Show', [
            'message' => $message,
            'users' => $all ?? User::find($users)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->deleteOrFail();

        DatabaseNotification::where('data->message_id', $message->id)->delete();

        return redirect()->route('admin.messages.index')->with('success', 'پیام با موفقیت حذف شد');
    }
}
