<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
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
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $this->userRepository->prepareUserData($request->validated());

        try {
            DB::transaction(function () use ($data) {
                $this->userRepository->create($data);
            });

            return redirect()->back()->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating user:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('An error occurred while creating the user.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userRepository->find($id);
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->userRepository->find($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $data = $this->userRepository->prepareUserData($request->validated(), 'update');

        try {
            DB::transaction(function () use ($id, $data) {
                $this->userRepository->update($id, $data);
            });

            return redirect()->route('user.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating user:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('An error occurred while updating the user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->userRepository->delete($id);

            return redirect()->route('user.index')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting user:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('An error occurred while deleting the user.');
        }
    }

    /**
     * Get user data
     * @param $request
     * @return array
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
