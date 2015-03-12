<?php

namespace admin;

use BaseController;
use WordService;
use CategoryService;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class WordController extends BaseController
{

    public function index()
    {
        if (strtolower(Input::get('format')) !== 'json') {
            return View::make('admin.words.index');
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

        $hasNext = False;
        $words = WordService::getWordWithAnswer($order, $direction, $offset, $limit, $hasNext);

        return Response::json([
            'hasNext' => $hasNext,
            'offset'  => $offset,
            'limit'   => $limit,
            'order'   => $order,
            'data'    => $words->toArray(),
            'dir'     => $direction,
        ]);
    }

    public function store()
    {
        $inputs = Input::all();

        $validator = WordService::validate('', $inputs);
        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            return Response::json(['message' => join('<br>', $messages)], 400);
        }
        log::info($inputs);
        $word = WordService::create($inputs);

        return Response::json($word, 201);
    }

    public function show($id)
    {
        $word = WordService::find($id);
        if (empty($word)) {
            App::abort(404, "Not Found");
        }
        $word['answer_content'] = WordService::getAnswer($id);
        $word['category_id'] = CategoryService::getName($id);
        $prev = WordService::prev($word);
        $next = WordService::next($word);
        $prev_id = isset($prev) ? $prev->id : 0;
        $next_id = isset($next) ? $next->id : 0;
        $data = [
            'item'    => $word,
            'next_id' => $next_id,
            'prev_id' => $prev_id,
        ];
        if (strtolower(Input::get('format')) !== 'json') {
            return View::make('admin.words.item', [
                'data' => $data
            ]);
        }

        return Response::json($data);
    }

    public function update($id)
    {
        $word = WordService::find($id);
        if (empty($word)) {
            App::abort(404, "Not Found");
        }

        $inputs = Input::all();

        $validator =  WordService::validate($id, $inputs);
        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            return Response::json(['message' => join('<br>', $messages)], 400);
        }
        WordService::update($word, $inputs);

        return Response::json($word, 200);
    }

    public function destroy($id)
    {
        $word = WordService::find($id);
        if (empty($word)) {
            App::abort(404, "Not Found");
        }
        WordService::delete($word);

        return Response::json([], 204);
    }
}
