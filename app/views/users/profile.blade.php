@extends('layouts.default')
<div class="container">
    <div>
        @if($currentUser)
            <p>Welcome to your profile page {{Auth::user()->username}} - {{Auth::user()->email}}</p>
        @endif
    </div>
</div>
