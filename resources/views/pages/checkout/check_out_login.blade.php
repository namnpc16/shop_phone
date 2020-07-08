@extends('welcome')
@section('content')
<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Login to your account</h2>
                    <form action="{{ URL::to('/login-customer') }}" method="POST">
                        @csrf
                        <input type="email" name="email_account" placeholder="Email Address" />
                        <input type="password" name="pass_account" placeholder="Password">
                        <span>
                            <input type="checkbox" class="checkbox"> 
                            Keep me signed in
                        </span>
                        <button type="submit" name="sbm" class="btn btn-default">Login</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>New User Signup!</h2>
                    <form action="{{ URL::to('/add-customer-sigup') }}" method="POST">
                        @csrf
                        <input type="text" name="name_sigup" placeholder="Name"/>
                        <input type="email" name="email_sigup" placeholder="Email Address"/>
                        <input type="text" name="phone_sigup" placeholder="Phone"/>
                        <input type="password" name="pass_sigup" placeholder="Password"/>
                        <button type="submit" name="sbm" class="btn btn-default">Signup</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->
@endsection