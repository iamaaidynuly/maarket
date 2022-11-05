@extends('adminlte::layout.main', ['title' => 'Значения'])

@section('content')
    @component('adminlte::page', ['title' => 'Значения'])
    @component('adminlte::box')
        @include('flash-message')

            <div class="col-md-12">
                <a href="/admin/size " title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br>
                <br>
                <p><b>Добавить новое значение</b></p>
            </div>
            <form action="/admin/size-items/{{$size->id}}/store" method="POST">
                @csrf
                <div class="col-md-4">
                    <input type="text" name="size_item[ru]" class="form-control" placeholder="{{ 'Наименование ru' }}" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="size_item[en]" class="form-control" placeholder="{{ 'Наименование en' }}" required>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Добавить</button>
                </div>
                
            </form>
            <br/>
            <br/>
            <br>
            <div class="col-md-12">
                <br>
                <p><b>Список значений</b></p>
            </div>
   
            @foreach($size_items as $item)
            
               
                    <div class="container-fluid form-group">
                        <div class="row">
                            <form action="/admin/size-items/{{$item->id}}/update" method="POST">
                                @csrf
                            <div class="col-md-4">
                                <input type="text" name="size_item[ru]" class="form-control" value="{{ $item->getTitle->ru }}" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="size_item[en]" class="form-control" value="{{ $item->getTitle->en }}" required>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-success" style="width: 100%;">Обновить</button>
                            </div>
                        </form>
                            <div class="col-md-1">
                                <form action="/admin/size-items/{{$item->id}}/delete" method="POST">
                                    @csrf
                                    <button class="btn btn-danger" style="width: 100%;">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div> 
                
            @endforeach
        @endcomponent
    @endcomponent
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-filter-item').on('click', function(e){
                e.preventDefault();
                console.log('select');
                let url = $(this).attr('href');
                console.log(url);
                $.ajax({
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    success: (response) => {
                        console.log(response);    
                    },
                    error: (error) => {
                    console.log(error);
                    }
                })
 
            });
        });
    </script>
@endpush
