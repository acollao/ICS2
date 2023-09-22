<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ICS 2.0') }}</title>
    <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
    <link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{url('css/login.css')}}" rel="stylesheet" />

    <script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{url('js/app.js')}}"></script>

</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="{{url('img/straive.png')}}" class="brand_logo" alt="Logo">
                    </div>

                </div>


                <div class="flex justify-content-center form_container">
                    <div class="widget-head mb-3" style="font-size:16px;text-transform:uppercase;letter-spacing:2px ">
                        <i class="fa fa-book"></i> Inventory Control System 2.0
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="username" class="form-control input_user" value="acollao" placeholder="username" required autofocus autocomplete="username">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="password" type="password" name="password" class="form-control input_pass" value="password" placeholder="password">

                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember_me">
                                <label class="custom-control-label" for="remember_me">Remember me</label>
                            </div>

                        </div>
                        <div class="d-flex justify-content-center mt-3 login_container">
                            <x-primary-button class="btn login_btn">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>

                    </form>
                </div>

                <div class="mt-4">
                    @if (Route::has('password.request'))
                    <div class="d-flex justify-content-right">
                        <a href="{{ route('password.request') }}" style="color:black">Forgot your password?</a>
                    </div>
                    @endif
                </div>
                <div class="mt-4">
                    @if(count($errors) > 0)
                    @foreach( $errors->all() as $message )
                    <div class="alert alert-danger display-hide">
                        <span>{{ $message }}</span>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
</body>

</html>