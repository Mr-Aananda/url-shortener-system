<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function paginate(int $perPage = 25)
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($perPage);
    }


    public function all()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function prepareUserData(array $data, string $from = 'create'): array
    {
        $primaryData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' => now(),
        ];

        if ($from === 'update') {
            if (!empty($data['password'])) {
                $primaryData['password'] = Hash::make($data['password']);
            }
        } else {
            $primaryData['password'] = Hash::make($data['password']);
        }

        return $primaryData;
    }
}
