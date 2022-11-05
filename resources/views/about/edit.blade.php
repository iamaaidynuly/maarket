@extends('adminlte::layout.main', ['title' => 'Редактировать'])
@section('content')
    @component('adminlte::page', ['title' => 'Редактировать'])
        @component('adminlte::box')
            @include('flash-message')
            <div class="card-body">
                <a href="{{url("/admin/about-us-block?slug=$aboutusblock->slug")}}" title="Назад">
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

                <form method="POST" action="{{ route('about-us-block.update', $aboutusblock->id) }}"
                      accept-charset="UTF-8"
                      class="form-horizontal" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    @include ('about.form', ['formMode' => 'edit'])

                </form>

            </div>
        @endcomponent
    @endcomponent
@endsection
@push('scripts')
    <script src="/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content_en');
        CKEDITOR.replace('content_ru');
        CKEDITOR.replace('content_kz');
    </script>
    <script>
        $(document).ready(function () {
            $('.delete-img-product').click(function () {
                console.log('click');
                let val = $(this).attr('data-id');
                $.ajax({
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/admin/about-delete-img/" + val,
                    success: (response) => {
                        if (response == 1) {
                            $(this).parent().parent().remove();
                        }
                    },
                    error: (error) => {
                        console.log(error);
                    }
                })
                console.log(val);
            });
        });
    </script>
@endpush
