<?php

class WordController extends \BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function listWord()
    {
        if (Input::get('filter')) {
            return View::make('words.index', [
                'filters'        => Config::get('word'),
                'words'        => WordService::getList(Input::get('category'), Input::get('filter')),
                'categoryData'    => CategoryService::getDataList(),
                'categoryId'    => Input::get('category'),
            ]);
        }

        return View::make('words.index', [
            'filters'        => Config::get('word'),
            // 'words' 		=> $words,
            'categoryData'    => CategoryService::getDataList(),
        ]);
    }

    public function filter()
    {
        if (Input::get('filter')) {
            return View::make('words.index', [
                'filters'        => Config::get('word'),
                'words' => WordService::getList(Input::get('category'), Input::get('filter')),
                'categoryData'    => CategoryService::getDataList(),
            ]);
        }
    }

}