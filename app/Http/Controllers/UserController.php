<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->has('limit')? $request->get('limit') : 20;
        $offset = $request->has('offset')? $request->get('offset') : 0;
        $data = User::offset($offset)->limit($limit)->get();
        return $this->success($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $user = new User();
//        $user->email = $params['email'];
//        $user->user_name = $params['user_name'];
//        $user->first_name = $params['first_name'];
//        $user->last_name = $params['last_name'];
//        $user->full_name = $params['first_name'] + $params['last_name'];
//        $user->password = $params['password'];
//        $user->email_verified_at = $params['email_verified_at']?: null;
//        $user->confirmation_code = $params['confirmation_code']?: null;
//        $user->timezone = $params['timezone']?: null;
//        $user->last_login_at = $params['last_login_at']?: null;
//        $user->last_login_ip = $params['last_login_ip']?: null;
        foreach ($params as $key => $param) {
            $user->$key = $param?: null;
        }
        $id = $user->save();
        return $this->success(['id' => $id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return $this->success(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user instanceof User) {
            $user->delete();
        }
        return $this->success(['id' => $id]);
    }
}
