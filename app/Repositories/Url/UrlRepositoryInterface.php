<?php

namespace App\Repositories\Url;

interface UrlRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function paginate(int $perPage = 25);

    public function findUrlByShortUrl(string $shortCode);
    public function incrementShortUrlClickCount($url);
    public function getAllUrlByUserId(int $userId);
}
