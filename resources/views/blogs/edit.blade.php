@extends('adminlte::layout.main', ['title' => 'Редактировать блог'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактировать блог'])
        @component('adminlte::box')
            <a href="{{ url('/admin/blogs') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
            <br />
            <br />

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="col-md-12">
                <form method="POST" action="{{ url('/admin/blogs/' . $blog->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    @include ('blogs.form', ['formMode' => 'edit'])

                </form>
            </div>
        @endcomponent
    @endcomponent
@endsection
