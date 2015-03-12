<?php

namespace admin;

use BaseController;
use CategoryService;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class CategoryController extends BaseController
{

    public function index()
    {
        if (strtolower(Input::get('format')) !== 'json') {
            return View::make('admin.categories.index');
        }

        $direction = strtolower(Input::get('dir', 'asc'));
        $order = strtolower(Input::get('order', 'id'));
        $offset = intval(Input::get('offset', 0));
        $limit = intval(Input::get('limit', 20));

        switch ($order) {
            case 'name':
                break;
            default:
                $order = 'id';
                break;
        }

        $categories = CategoryService::get($order, $direction, $offset, $limit + 1);

        $hasNext = false;
        if (count($categories) > $limit) {
            $categories = $categories->slice(0, $limit);
            $hasNext = true;
        }

        return Response::json([
            'hasNext' => $hasNext,
            'offset'  => $offset,
            'limit'   => $limit,
            'order'   => $order,
            'data'    => $categories->toArray(),
            'dir'     => $direction,
        ]);
    }

    public function store()
    {
        $inputs = Input::all();

        $validator = CategoryService::validate('', $inputs);
        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            return Response::json(['message' => join('<br>', $messages)], 400);
        }
        $category = CategoryService::create($inputs);

        return Response::json($category, 201);
    }

    public function show($id)
    {
        $category = CategoryService::find($id);
        if (empty($category)) {
            App::abort(404, "Not Found");
        }
        $prev = CategoryService::prev($category);
        $next = CategoryService::next($category);
        $prev_id = isset($prev) ? $prev->id : 0;
        $next_id = isset($next) ? $next->id : 0;
        $data = [
            'item'    => $category,
            'next_id' => $next_id,
            'prev_id' => $prev_id,
        ];
        if (strtolower(Input::get('format')) !== 'json') {
            return View::make('admin.categories.item', [
                'data' => $data
            ]);
        }

        return Response::json($data);
    }

    public function update($id)
    {
        $category = CategoryService::find($id);
        if (empty($category)) {
            App::abort(404, "Not Found");
        }

        $inputs = Input::all();

        $validator =  CategoryService::validate($id, $inputs);
        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            return Response::json(['message' => join('<br>', $messages)], 400);
        }
        CategoryService::update($category, $inputs);

        return Response::json($category, 200);
    }

    public function destroy($id)
    {
        $category = CategoryService::find($id);
        if (empty($category)) {
            App::abort(404, "Not Found");
        }
        CategoryService::delete($category);

        return Response::json([], 204);
    }
}
