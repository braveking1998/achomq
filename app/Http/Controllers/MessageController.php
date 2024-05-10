<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = DatabaseNotification::where('notifiable_id', Auth::user()->id)->where('type', 'App\Notifications\AdminMessage')->orderByRaw('-`read_at` ASC')->latest()->paginate(10);

        return Inertia::render('Messages/Index', [
            'messages' => $messages,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = DatabaseNotification::find($id);

        if (!$message) {
            return redirect()->route('messages.index');
        }
        // Mark read
        $message->update(['read_at' => now()]);

        if ($message->type === "App\Notifications\MultiplayNotification") {
            $game_id = $message->data['game_id'];
            return redirect()->route('multi-play');
        }

        return Inertia::render('Messages/Show', [
            'message' => $message
        ]);
    }

    public function destroy(string $id)
    {
        $message = DatabaseNotification::find($id);

        $message->delete();

        return redirect()->route('messages.index')->with('success', 'پیام حذف شد.');
    }
}
