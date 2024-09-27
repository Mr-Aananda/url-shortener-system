<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UrlRequest;
use App\Http\Resources\UrlResource;
use App\Repositories\Url\UrlRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UrlApiController extends Controller
{
    protected $urlRepository;

    public function __construct(UrlRepositoryInterface $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $urls = $this->urlRepository->getAllUrlByUserId(Auth::id());

        $urlResource = UrlResource::collection($urls);

        return response()->json([
            'data' => $urlResource,
            'message' => 'URLs retrieved successfully.',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UrlRequest $request): JsonResponse
    {
        $shortUrl = $request->short_url ?: Str::random(10);

        try {
            $url = DB::transaction(function () use ($request, $shortUrl) {
                return $this->urlRepository->create([
                    'long_url' => $request->input('long_url'),
                    'short_url' => $shortUrl,
                    'user_id' => Auth::id(),
                ]);
            });

            return response()->json([
                'data' => new UrlResource($url),
                'message' => 'URL created successfully!',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating URL:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while creating the URL.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $shortUrl): JsonResponse
    {
        $url = $this->urlRepository->findUrlByShortUrl($shortUrl);

        if (!$url) {
            return response()->json(['error' => 'URL not found.'], 404);
        }

        return response()->json([
            'data' => new UrlResource($url),
            'message' => 'URL retrieved successfully.',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UrlRequest $request, string $id): JsonResponse
    {
        $shortUrl = $request->short_url ?: Str::random(10);

        try {
            $url = DB::transaction(function () use ($id, $request, $shortUrl) {
                return $this->urlRepository->update($id, [
                    'long_url' => $request->input('long_url'),
                    'short_url' => $shortUrl,
                ]);
            });

            return response()->json([
                'data' => new UrlResource($url),
                'message' => 'URL updated successfully.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating URL:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while updating the URL.'], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $this->urlRepository->delete($id);
            });

            return response()->json(['message' => 'URL deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting URL:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while deleting the URL.'], 500);
        }
    }

    /**
     * Redirect the short URL to the main URL.
     */
    public function redirectToMainUrl(string $shortUrl): JsonResponse
    {
        $url = $this->urlRepository->findUrlByShortUrl($shortUrl);

        if (!$url) {
            return response()->json(['error' => 'URL not found.'], 404);
        }

        $this->urlRepository->incrementShortUrlClickCount($url);

        return response()->json([
            'data' => new UrlResource($url),
            'message' => 'Redirecting to the main URL.',
        ], 200);
    }

}
