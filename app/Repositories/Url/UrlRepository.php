<?php

namespace App\Repositories\Url;

use App\Models\Url;

class UrlRepository implements UrlRepositoryInterface
{
    public function all()
    {
        return Url::all();
    }

    public function find($id)
    {
        return Url::findOrFail($id);
    }

    public function create(array $data)
    {
        return Url::create($data);
    }

    public function update($id, array $data)
    {
        $url = $this->find($id);
        $url->update($data);
        return $url;
    }

    public function delete($id)
    {
        Url::destroy($id);
    }

    public function paginate(int $perPage = 25)
    {
        return Url::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findByShortUrl(string $shortUrl)
    {
        return Url::where('short_url', $shortUrl)->firstOrFail();
    }

    public function incrementClickCount($url)
    {
        $url->increment('click_count');
    }

    public function getAllByUserId(int $userId, int $perPage = 25)
    {
        return Url::where('user_id', $userId)->paginate($perPage);
    }
}
