<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UrlRequest;
use App\Repositories\Url\UrlRepositoryInterface;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UrlApiController extends Controller
{
    use HttpResponses;
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

        return $this->success($urls, 'URLs retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UrlRequest $request)
    {
        $shortUrl = $request->short_url ? $request->short_url : Str::random(10);

        $url = $this->urlRepository->create([
            'long_url' => $request->input('long_url'),
            'short_url' => $shortUrl,
            'user_id' => Auth::id(),
        ]);

        return $this->success($url, 'URL created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($shortUrl)
    {
        $url = $this->urlRepository->findByShortUrl($shortUrl);

        if (!$url) {
            return $this->error(null, 'URL not found.', 404);
        }

        return $this->success($url, 'URL retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UrlRequest $request, string $id)
    {
        $url = $this->urlRepository->update($id, $request->validated());

        return $this->success($url, 'URL updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->urlRepository->delete($id);

        return $this->success(null, 'URL deleted successfully.');
    }

    /**
     * Redirect the short URL to the main URL.
     */
    public function redirectToMainUrl($shortUrl)
    {
        $url = $this->urlRepository->findByShortUrl($shortUrl);

        if (!$url) {
            return $this->error(null, 'URL not found.', 404);
        }

        $this->urlRepository->incrementClickCount($url);

        return $this->success($url->long_url, 'Redirecting to the long URL.');
    }
}
