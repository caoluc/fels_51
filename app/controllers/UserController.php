<?php

class UserController extends \BaseController
{
    /**
     * Profile User.
     *
     * @return view
     */
    public function show($id)
    {
        $currentUser = Auth::user();
        $activities = LessonService::getActivities($currentUser->id);

        return View::make('users.profile', [
            'currentUser' => $currentUser,
            'activities'  => $activities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('users.signup');
    }

    public function store()
    {
        $data = Input::only(['username', 'email', 'password', 'avatar_url']);
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
                $filename        = str_random(6).'_'.$file->getClientOriginalName();
                $uploadSuccess   = $file->move($destinationPath, $filename);
            }
            $user = new User();
            $user->username = Input::get('username');
            $user->email = Input::get('email');
            $user->avatar_url = '/img/'.$filename;
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            Auth::attempt(array('email' => $user->email, 'password' => Input::get('password')));

            return Redirect::to(url_ex('/'))->with('message', 'Thanks for registering!');
        } else {
            return Redirect::to(url_ex('register'))->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
        }
    }
}
