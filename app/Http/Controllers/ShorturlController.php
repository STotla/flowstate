<?php

namespace App\Http\Controllers;

use App\Models\Shorturl;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShorturlController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Shorturl::query()->with(['company', 'user']);

        if (auth()->user()->hasRole('Admin')) {
            $query->where('company_id', auth()->user()->company_id);
        } elseif (!auth()->user()->hasRole('SuperAdmin')) {
            $query->where('user_id', auth()->id());
        }

        $query->when($request->filled('company'), function ($q) use ($request) {
            return $q->where('company_id', $request->input('company'));
        });

        $query->when($request->filled('user'), function ($q) use ($request) {
            return $q->where('user_id', $request->input('user'));
        });

        $shortUrls = $query->paginate(10);

        return view('shorturls.index', compact('shortUrls'));
    }

    public function create()
    {
        $this->authorize('create', Shorturl::class);
        return view('shorturls.create');
    }


    public function store(Request $request)
    {
        $this->authorize('create', Shorturl::class);
        $request->validate([
            'original_url' => 'required|url',
        ]);
        $companyName = auth()->user()->company->name;
        $clean = Str::of($companyName)->replace(' ', '')->lower();
        do {
            $shortCode = $clean . '-' . Str::lower(Str::random(6));
        } while (Shorturl::where('short_url', $shortCode)->exists());

        try{
            Shorturl::create([
                
                'original_url' => $request->original_url,
                'short_url' => $shortCode,
                'company_id' => auth()->user()->company_id,
                'user_id' => auth()->id(),
                ]);
        } catch (\Exception $e) {
            return redirect()->route('shorturls.create')->withErrors(['original_url' => 'Failed to create short URL. Please try again.']);
        }

        return redirect()->route('shorturls.index')->with('success', 'Short URL created successfully.');
    }
}
