@extends('adminlte::auth.layout', ['title' => trans('adminlte::adminlte.sign_in')])

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ config('adminlte.urls.base') }}">
                {!! config('adminlte.logo') !!}
                shops
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            @include('flash-message')

            <p class="login-box-msg">
                @lang('adminlte::adminlte.login_message')
            </p>
            <form method="post" action="{{route('shop.login')}}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input name="email" value="{{ old('email') }}" placeholder="Email" class="form-control" autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" placeholder="Password"
                           class="form-control @error('password') is-invalid @enderror">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            sign in
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
