@extends('adminlte::layout.main', ['title' => 'Добавить'])
@section('content')
    @component('adminlte::page', ['title' => 'Добавить'])
        @component('adminlte::box')
            @include('flash-message')
            <div class="card-body">
                <a href="{{ url('/admin/reviews') }}" title="Назад">
                    <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад
                    </button>
                </a>
                <br/>
                <br/>

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="col-md-12">
                    <form method="POST" action="{{ url('/admin/reviews') }}" accept-charset="UTF-8"
                          class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @include ('reviews.form', ['formMode' => 'create'])

                    </form>

                </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
@push('scripts')
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('review');
    </script>
@endpush
