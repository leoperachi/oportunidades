@extends('layouts.login')

@section('content')

<div class="">
    <div class="row justify-content-end">
        <div class="col-lg-3 col-md-5 card-login">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="d-flex justify-content-center">
                            <img src="img/logo_cliente.png" alt="">
                        </div>
                        <div class="form-group form-group-input row">
                            <div class="col-md-12">
                                <input id="email" type="email"   required autofocus 
                                    placeholder="E-mail" name="email" value="{{ old('email') }}" 
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group form-group-input row">
                            <div class="col-md-12">
                                <input id="password" type="password"  placeholder="Password" 
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
                                    name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
    
                        <div class="form-group form-group-button row">
                            <div class="col-md-12">
                                <div class="float-right">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@yield('scripts')
<script>
    $(document).ready(function(){
        $(".btn-primary").click(function(){
            $("#loading").show(); 
        });

        setTimeout(() => {
            $("#loading").hide();    
        }, 500);
    });
</script>
@endsection
