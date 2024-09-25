<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    use HttpResponses;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userRepository->paginate(25);
        return $this->success($users, 'Users retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest  $request)
    {
        $data = $this->getUserData($request, 'create');

        try {
            DB::transaction(function () use ($data) {
                $this->userRepository->create($data);
            });

            return $this->success([], 'User created successfully!', 201); // Use the success method
        } catch (\Exception $e) {
            Log::error('Error creating user:', ['error' => $e->getMessage()]);
            return $this->error('', 'An error occurred while creating the user.', 500); // Use the error method
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->error('', 'User not found.', 404);
        }

        return $this->success($user, 'User retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $data = $this->getUserData($request, 'update');

        try {
            DB::transaction(function () use ($id, $data) {
                $this->userRepository->update($id, $data);
            });

            return $this->success([], 'User updated successfully.'); // Use the success method
        } catch (\Exception $e) {
            Log::error('Error updating user:', ['error' => $e->getMessage()]);
            return $this->error('', 'An error occurred while updating the user.', 500); // Use the error method
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->userRepository->delete($id);
            return $this->success([], 'User deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting user:', ['error' => $e->getMessage()]);
            return $this->error('', 'An error occurred while deleting the user.', 500);
        }
    }


    /**
     * Prepare user data for creating or updating.
     */
    private function getUserData($request, $from = 'create'): array
    {
        $primary_data = [
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
        ];

        if ($from === 'update') {
            if ($request->password) {
                $primary_data['password'] = Hash::make($request->password);
            }
            return $primary_data;
        } else {
            $create_data = [
                'password' => Hash::make($request->password),
            ];
            return array_merge($primary_data, $create_data);
        }
    }
}
