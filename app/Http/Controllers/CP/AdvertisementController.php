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
            'title'     => ['required', 'string', 'min:6'],
            'url'       => ['nullable', 'url', 'active_url'],
            'image'     => ['required', 'image'],
            'published' => ['nullable', 'boolean'],
        ]);

        $advertisement = Advertisement::create([
            'title'     => $request->title,
            'url'       => $request->url,
            'published' => $request->published ? true : false,
        ]);

        $advertisement->setImage($request->file('image'));

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
            'title'     => ['required', 'string', 'min:6'],
            'url'       => ['nullable', 'url', 'active_url'],
            'image'     => ['image'],
            'published' => ['nullable', 'boolean'],
        ]);

        $advertisement->update([
            'title'     => $request->title,
            'url'       => $request->url,
            'published' => $request->published ? true : false,
        ]);

        if (request()->has('image')) {
            Storage::disk('advertisements')->delete($advertisement->image_path);
            $advertisement->setImage(request()->file('image'));
        }

        flash(__('messages.advertisement.update'));

        return redirect()->route('advertisements.index');
    }

    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();

        flash(__('messages.advertisement.delete'));

        return redirect()->route('advertisements.index');
    }
}
