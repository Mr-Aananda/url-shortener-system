<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = $this->userRepository->paginate(25);
        return response()->json(['data' => $users, 'message' => 'Users retrieved successfully.'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $this->userRepository->prepareUserData($request->validated());

        try {
            DB::transaction(function () use ($data) {
                $this->userRepository->create($data);
            });

            return response()->json(['message' => 'User created successfully!'], 201);
        } catch (\Exception $e) {
            Log::error('Error creating user:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while creating the user.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        return response()->json(['data' => $user, 'message' => 'User retrieved successfully.'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id): JsonResponse
    {
        $data = $this->userRepository->prepareUserData($request->validated(), 'update');

        try {
            DB::transaction(function () use ($id, $data) {
                $this->userRepository->update($id, $data);
            });

            return response()->json(['message' => 'User updated successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating user:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while updating the user.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->userRepository->delete($id);
            return response()->json(['message' => 'User deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting user:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while deleting the user.'], 500);
        }
    }
}
