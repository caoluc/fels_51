<?php

class HomeController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |	Route::get('/', 'HomeController@showWelcome');
    |
    */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth');
    }

    public function index()
    {
        $currentUser = Auth::user();
        CategoryService::getDataList();
        $activities = LessonService::getAllActivities($currentUser->id);

        return View::make('home', [
            'currentUser' => $currentUser,
            'activities'  => $activities,
        ]);
    }
}
