<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index()
    {
        return view('advertisements.index')->with('advertisements', Advertisement::all());
    }

    public function create()
    {
        return view('advertisements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:6'],
            'url' => ['nullable', 'url', 'active_url'],
            'image' => ['required', 'image']
        ]);

        $advertisement = Advertisement::create([
            'title' => $request->title,
            'url' => $request->url,
        ]);

        $path = request()->file('image')
            ->storeAs(
                'advertisements',
                $advertisement->id . '-' . time() . '.' . request()->file('image')->extension(),
                ['disk' => 'public']
            );

        $advertisement->update([
            'image_path' => $path
        ]);

        flash(__('messages.advertisement.create'));

        return redirect()->route('advertisements.index');
    }

    public function edit(Advertisement $advertisement)
    {
        return view('advertisements.edit')->with('advertisement', $advertisement);
    }

    public function update(Advertisement $advertisement, Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:6'],
            'url' => ['nullable', 'url', 'active_url'],
            'image' => ['image']
        ]);

        $advertisement->update([
            'title' => $request->title,
            'url' => $request->url,
        ]);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($advertisement->image_path);

            $path = request()->file('image')
                ->storeAs(
                    'advertisements',
                    $advertisement->id . '-' . time() . '.' . request()->file('image')->extension(),
                    ['disk' => 'public']
                );
            $advertisement->update([
                'image_path' => $path,
            ]);
        }

        flash(__('messages.advertisement.update'));

        return redirect()->route('advertisements.index');
    }
}
