<?php

use Illuminate\Support\Facades\Validator;

class UserService extends BaseService
{
    public static function find($id)
    {
        return User::find($id);
    }

    public static function get($order, $direction, $offset, $limit)
    {
        return User::orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }


    public static function create($input)
    {
        $user = new User;

        return UserService::update($user, $input);
    }

    public static function update($user, $input)
    {
        $user->username  = array_get($input, 'username',  $user->username);
        $user->email = array_get($input, 'email', $user->email);
        $user->role = array_get($input, 'role', $user->role);
        $password = array_get($input, 'password');
        if (!empty($password)) {
            $user->setPassword($password);
        }
        $user->save();
        
        return $user;
    }

    public static function save($user)
    {
        return $user->save();
    }

    public static function delete($user)
    {
        return $user->delete();
    }

    public static function next($user)
    {
        return User::where('id', '>', $user->id)->orderBy('id', 'asc')->first();
    }

    public static function prev($user)
    {
        return User::where('id', '<', $user->id)->orderBy('id', 'desc')->first();
    }

    public static function validate($id, $inputs)
    {
        $validationRules = [
            'username'  => ['required'],
            'email'     => ['required', 'email', 'unique:users,email,' . $id . ',id,deleted_at,NULL'],
            'password'  => 'required|min:6',
            
        ];
        if (isset($id)) {
            $validationRules = [
                'email'      => ['required'],
            ];
        }

        $validationMessages = [
            'username.required'     => Lang::get('validation.users.username.required'),
            'email.required'    => Lang::get('validation.users.email.required'),
            'email.email'       => Lang::get('validation.users.email.email'),
            'email.unique'      => Lang::get('validation.users.email.unique'),
            'password.required' => Lang::get('validation.users.password.required'),
            'password.min'      => Lang::get('validation.users.password.min'),
        ];

        return Validator::make($inputs, $validationRules, $validationMessages);
    }

    /**
     * Check user's permissions
     *
     * @return bool
     */
    public static function isAdmin()
    {
        if(Auth::user()->role == 1) {
            return true;
        }

        return false;
    }

    public static function follow($userId, $followId)
    {
        $userFollow = UserFollow::where('user_id', '=', $userId)->where('follow_id', '=', $followId)->first();
        if ($userFollow) {
            return true;
        }

        return false;
    }
}
