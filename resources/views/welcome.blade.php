@extends('layouts.master')

@section('title')
    Welcome!
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-centered well">


            <form action="#" method="post">
                <h3 class="text-centered">Login to your dashboard</h3>
                <div  class="form-group">
                    <label for="email">Your email</label>
                    <input class="form-control" type="text"  name="email" id="email" placeholder="Email">
                </div>

            </form>

            <div class="btn-group">
                <a href="{{ url('auth/google') }}"
                   class="btn btn-block btn-social btn-google" type="submit">
                    <span class="fa fa-google-plus"></span> Sign in with Google
                </a>

            </div>

        </div>
    </div>

@endsection


