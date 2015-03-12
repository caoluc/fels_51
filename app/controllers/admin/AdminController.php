<?php

namespace Admin;
use UserService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class AdminController extends \BaseController {

    public function __construct()
    {
        if (!Auth::user()->isAdmin()) {
            return Redirect::to('/');
        }
    }

    public function getHome() {

        return \View::make('admin.home');
    }
}