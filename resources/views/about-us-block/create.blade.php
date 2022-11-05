@extends('adminlte::layout.main', ['title' => 'Добавление блока'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавление блока'])
        @component('adminlte::box')
            <div class="md-12">
                <a href="{{ url('/admin/about-us-block') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br />
                <br />

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ url('/admin/about-us-block') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @include ('about-us-block.form', ['formMode' => 'create'])

                </form>
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