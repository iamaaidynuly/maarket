@extends('adminlte::layout.main', ['title' => 'Добавить новость'])
@section('content')
    @component('adminlte::page', ['title' => 'Добавить новость'])
        @component('adminlte::box')
            @include('flash-message')
            <div class="card-body">
                <a href="{{route('news.index')}}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
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
                    <form method="POST" action="{{ route('news.store') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @include ('news.form', ['formMode' => 'create'])

                    </form>
                </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
@push('scripts')
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'content_en' );
        CKEDITOR.replace( 'content_ru' );
        CKEDITOR.replace( 'content_kz' );
    </script>
@endpush
