@extends('adminlte::layout.main', ['title' => 'Редактировать фильтр'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактировать фильтр'])
        @component('adminlte::box')

            <div class="md-12">
                <a href="{{ url('/admin/filters') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br />
                <br />

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ url('/admin/filters/' . $filter->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    @include ('filters.form', ['formMode' => 'edit'])

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