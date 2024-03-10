<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Traits\ApiResponser; // Import the ApiResponser trait

class UserController extends Controller
{
    use ApiResponser; // Use the ApiResponser trait

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the list of users.
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->successResponse($users);
    }

    /**
     * Add a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function addUser(Request $request)
    {
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female'
        ];

        $this->validate($request, $rules);

        $user = User::create($request->all());
        return $this->successResponse($user, Response::HTTP_CREATED);
    }
}
