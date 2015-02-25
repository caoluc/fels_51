<?php

class SessionController extends \BaseController
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Auth::check()) {
            return Redirect::to('/')->with('message', 'Your are logged in');
        } else {
            return View::make('users.login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::only(['email', 'password']);
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return Redirect::to('/');
        }

        return Redirect::to(url_ex('login'))->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy()
    {
        Auth::logout();

        return Redirect::to(url_ex('/'));
    }
}
