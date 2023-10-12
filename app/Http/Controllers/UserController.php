<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\IndexRequest;
use App\Http\Resources\Users\UserItemCollection;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Support\AppConstant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $params = $request->validated();

        $from = 0;
        $to = 25;

        if (array_key_exists(AppConstant::SEARCH_FROM, $params)
            && array_key_exists(AppConstant::SEARCH_TO, $params)) {
            $from = $params[AppConstant::SEARCH_FROM];
            $to = $params[AppConstant::SEARCH_TO];
        }

        $page = AppConstant::getCurrentPage($from, $to);
        $perPage = AppConstant::getPerPage($from, $to);

        /** @var LengthAwarePaginator $data */
        $data = $this->userRepository->getAll($params, $perPage, $page);
        $total = $data->total();
        $current = count($data);

        return response()->json(new UserItemCollection($data), 200, [
            'X-Total-Count' => "items $from-$current/$total",
            'Content-Range' => "items $from-$current/$total",
            'Access-Control-Expose-Headers' => 'Content-Range',
        ]);
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
