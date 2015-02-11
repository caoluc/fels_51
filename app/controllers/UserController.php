<?php

class UserController extends \BaseController {

    /**
     * Profile User
     *
     * @return view
     */
    public function profile()
    {
        return View::make('users.profile');
    }
    /**
     * Post form login
     *
     * @return
     */
    public function postLogin()
    {
        $data = Input::only(['email', 'password']);

        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            return Redirect::to('/');
        }

        return Redirect::to(url_ex('login'))->withInput();
    }
    /**
     * Show form login
     *
     * @return View
     */
    public function login()
    {
        return View::make('users.login');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return Redirect::to(url_ex('/'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('users.create');
    }

    public function getRegister()
    {
        return View::make('users.create');
    }
    public function postRegister()
    {
        $data = Input::only(['username','email','password', 'avatar_url']);
        $validator = Validator::make(
            $data,
            [
                'username' => 'required',
                'email' => 'required|email|min:8',
                'password' => 'required',
            ]
        );
        if ($validator->passes()) {
            $destinationPath = '';
            $filename        = '';

            if (Input::hasFile('avatar_url')) {
                $file            = Input::file('avatar_url');
                $destinationPath = public_path().'/img/';
                $filename        = str_random(6) . '_' . $file->getClientOriginalName();
                $uploadSuccess   = $file->move($destinationPath, $filename);
            }

            $user = new User;
            $user->username = Input::get('username');
            $user->email = Input::get('email');
            $user->avatar_url = '/img/' . $filename;
            $user->password = Hash::make(Input::get('password'));

            $user->save();
            Auth::attempt( array('email' => $user->email, 'password' => Input::get('password')) );
            return Redirect::to(url_ex('/'))->with('message', 'Thanks for registering!');
        } else {
            return Redirect::to(url_ex('register'))->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
