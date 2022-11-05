@extends('adminlte::layout.main', ['title' => 'SEO'])

@section('content')
    @component('adminlte::page', ['title' => 'SEO'])
        @component('adminlte::box')
            <div class="col-md-12">
                <a href="{{ url('/admin/static-seo') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br />
                <br />

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ url('/admin/static-seo/' . $staticseo->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    @include ('static-seo.form', ['formMode' => 'edit'])

                </form>

            </div>
        @endcomponent
    @endcomponent
@endsection
