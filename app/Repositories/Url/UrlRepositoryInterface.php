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

    // Additional methods specific to URL shortener functionality
    public function findByShortUrl(string $shortCode);
    public function incrementClickCount($url);
    public function getAllByUserId(int $userId);
}
