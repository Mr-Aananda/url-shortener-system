<?php

namespace App\Repositories\User;


interface UserRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function paginate(int $perPage = 25);
    public function prepareUserData(array $data, string $from = 'create'): array;
}
