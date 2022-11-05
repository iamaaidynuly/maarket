@extends('adminlte::layout.main', ['title' => 'Добавить'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавить'])
        @component('adminlte::box')
            <div class="col-md-12">
                <a href="{{ url('/admin/size') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br />
                <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/admin/size') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('size.form', ['formMode' => 'create'])

                        </form>

            </div>
    @endcomponent
    @endcomponent
@endsection
@push('scripts')
    <script>
        $('div.add_filter_item').on('click', function(){
            $("div#filter_items").append('<div class="form-group row""><div class="col-md-5"><input type="text" name="filter_item[ru][]" class="form-control" placeholder="Значение на русском" autocomplete="off" required></div> <div class="col-md-5"><input type="text" name="filter_item[en][]" class="form-control" placeholder="Значение на английском" autocomplete="off"></div><div class="col-md-2"><div class="btn btn-danger delete_filter_item">Удалить</div></div></div>');
            deleteEl();
        });
        function deleteEl(){
            $('div.delete_filter_item').click(function(){
                $(this).parent().parent().remove();
            })
        }
    </script>
@endpush
