<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response; // Add this line

class UserController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Return the list of users
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200); // Assuming successResponse and errorResponse are replaced with Laravel's response methods
    }

    public function add(Request $request)
    {
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
        ];
        $this->validate($request, $rules);
        $user = User::create($request->all());
        return response()->json($user, Response::HTTP_CREATED); // Assuming successResponse and errorResponse are replaced with Laravel's response methods
    }

    /**
     * Obtains and show one user
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200); // Assuming successResponse and errorResponse are replaced with Laravel's response methods
    }

    /**
     * Update an existing author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender' => 'in:Male,Female',
        ];
        $this->validate($request, $rules);
        $user = User::findOrFail($id);

        $user->fill($request->all());
        // if no changes happen
        if ($user->isClean()) {
            return response()->json('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY); // Assuming successResponse and errorResponse are replaced with Laravel's response methods
        }
        $user->save();
        return response()->json($user, 200); // Assuming successResponse and errorResponse are replaced with Laravel's response methods
    }

    /**
     * Remove an existing user
     * @return Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json($user, 200); // Assuming successResponse and errorResponse are replaced with Laravel's response methods
    }
}
