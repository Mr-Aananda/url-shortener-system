<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Repositories\Url\UrlRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UrlController extends Controller
{
    protected $urlRepository;

    public function __construct(UrlRepositoryInterface $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = $this->urlRepository->getAllUrlByUserId(Auth::id());
        return view('url.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('url.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UrlRequest $request)
    {
        $shortUrl = $request->short_url ?: Str::random(10);

        try {
            DB::transaction(function () use ($request, $shortUrl) {
                $this->urlRepository->create([
                    'long_url' => $request->input('long_url'),
                    'short_url' => $shortUrl,
                    'user_id' => Auth::id(),
                ]);
            });

            return redirect()->back()->with('success', 'URL Created Successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating URL:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('An error occurred while creating the URL.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $shortUrl)
    {
        try {
            $url = $this->urlRepository->findUrlByShortUrl($shortUrl);
            return view('url.show', compact('url'));
        } catch (\Exception $e) {
            Log::error('Error displaying URL:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('An error occurred while displaying the URL.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $shortUrl)
    {
        try {
            $url = $this->urlRepository->findUrlByShortUrl($shortUrl);
            return view('url.edit', compact('url'));
        } catch (\Exception $e) {
            Log::error('Error editing URL:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('An error occurred while editing the URL.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UrlRequest $request, string $id)
    {
        try {
            $data = $request->only(['long_url']);
            $data['short_url'] = $request->short_url ? $request->short_url : Str::random(10);

            DB::transaction(function () use ($id, $data) {
                $this->urlRepository->update($id, $data);
            });

            return redirect()->route('url.index')->with('success', 'URL Updated Successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating URL:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('An error occurred while updating the URL.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $this->urlRepository->delete($id);
            });

            return redirect()->route('url.index')->with('success', 'URL Deleted Successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting URL:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('An error occurred while deleting the URL.');
        }
    }

    /**
     * Redirect the short URL to the main URL.
     */
    public function redirectToMainUrl($shortUrl)
    {
        $url = $this->urlRepository->findUrlByShortUrl($shortUrl);

        if (!$url) {
            return redirect()->back()->withErrors('URL not found.');
        }
        $this->urlRepository->incrementShortUrlClickCount($url);

        return redirect()->to($url->long_url);
    }

}
