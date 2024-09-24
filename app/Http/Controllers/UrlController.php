<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Repositories\Url\UrlRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
        $urls = $this->urlRepository->getAllByUserId(Auth::id());
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
        // If no custom short url from request then create random short url
        $shortUrl = $request->short_url ? $request->short_url : Str::random(10);

        $this->urlRepository->create([
            'long_url' => $request->input('long_url'),
            'short_url' => $shortUrl,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'URL Created Successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($shortUrl)
    {
        $url = $this->urlRepository->findByShortUrl($shortUrl);
        return view('url.show', compact('url'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $url = $this->urlRepository->find($id);
        return view('url.edit', compact('url'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UrlRequest $request, string $id)
    {
        $this->urlRepository->update($id, $request->only(['long_url', 'short_url']));

        return redirect()->route('url.index')->with('success', 'URL Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->urlRepository->delete($id);
        return redirect()->route('url.index')->with('success', 'URL Deleted Successfully.');
    }

    public function redirectTOMainUrl($shortUrl)
    {
        $url = $this->urlRepository->findByShortUrl($shortUrl);
        $this->urlRepository->incrementClickCount($url);
        return redirect()->to($url->long_url);
    }

}
