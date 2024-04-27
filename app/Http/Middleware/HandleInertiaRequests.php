<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use App\Models\ProfileImage;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $selectedImage = ($request->user()) ? ProfileImage::find($request->user()->profile_image) : false;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'messages' => DatabaseNotification::where('notifiable_id', $request->user()->id)->where('read_at', null)->latest()->limit(3)->get(),
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
