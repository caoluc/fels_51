<?php

namespace admin;

use BaseController;
use UserService;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class UserController extends BaseController
{

    public function __construct()
    {
    }

    public function index()
    {
        if (strtolower(Input::get('format')) !== 'json') {
            return View::make('admin.users.index');
        }

        $direction = strtolower(Input::get('dir', 'asc'));
        $order = strtolower(Input::get('order', 'id'));
        $offset = intval(Input::get('offset', 0));
        $limit = intval(Input::get('limit', 20));

        switch ($order) {
            case 'name':
            case 'email':
                break;
            default:
                $order = 'id';
                break;
        }

        $users = UserService::get($order, $direction, $offset, $limit + 1);

        $hasNext = false;
        if (count($users) > $limit) {
            $users = $users->slice(0, $limit);
            $hasNext = true;
        }

        return Response::json([
            'hasNext' => $hasNext,
            'offset'  => $offset,
            'limit'   => $limit,
            'order'   => $order,
            'data'    => $users->toArray(),
            'dir'     => $direction,
        ]);
    }

    public function show($id)
    {
        $user = UserService::find($id);
        if (empty($user)) {
            App::abort(404, "Not Found");
        }
        $prev = UserService::prev($user);
        $next = UserService::next($user);
        $prev_id = isset($prev) ? $prev->id : 0;
        $next_id = isset($next) ? $next->id : 0;
        $data = [
            'item'    => $user,
            'next_id' => $next_id,
            'prev_id' => $prev_id,
        ];
        if (strtolower(Input::get('format')) !== 'json') {
            return View::make('admin.users.item', [
                'data' => $data
            ]);
        }

        return Response::json($data);
    }

    public function store()
    {
        $inputs = Input::all();

        $validator = UserService::validate('', $inputs);
        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            return Response::json(['message' => join('<br>', $messages)], 400);
        }
        $category = UserService::create($inputs);

        return Response::json($category, 201);
    }

    public function update($id)
    {
        $user = UserService::find($id);
        if (empty($user)) {
            App::abort(404, "Not Found");
        }

        $inputs = Input::all();
        log::info($inputs);

        $validator =  UserService::validate($id, $inputs);
        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            return Response::json(['message' => join('<br>', $messages)], 400);
        }
        UserService::update($user, $inputs);

        return Response::json($user, 200);
    }

    public function destroy($id)
    {
        $user = UserService::find($id);
        if (empty($user)) {
            App::abort(404, "Not Found");
        }
        UserService::delete($user);

        return Response::json([], 204);
    }
}
