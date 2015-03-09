<?php

class CategoryController extends \BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = CategoryService::getALl();

        return View::make('categories.index', ['categories' => $categories]);
    }

}