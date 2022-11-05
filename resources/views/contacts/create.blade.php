@extends('adminlte::layout.main', ['title' => 'Добавить'])

@section('content')
    @component('adminlte::page', ['title' => 'Добавить'])
        @component('adminlte::box')
            <div class="col-md-12">
                <a href="{{ url('/admin/contacts') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                <br />
                <br />

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <form method="POST" action="{{ url('/admin/contacts') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @include ('contacts.form', ['formMode' => 'create'])

                </form>
            </div>
        @endcomponent
    @endcomponent
@endsection
@push('scripts')
   <script>
       $( document ).ready(function() {
            deletePhone();
            $('#add_phone').click(function(){
                $('#phones').append('<div class="row"><div class="col-md-6"><div class="form-group"><input class="form-control" name="phone_number[]" type="text" id="phone_number" value="" placeholder="Введите номер"></div></div><div class="col-md-6"><span class="btn btn-danger delete_phone">Удалить</span></div></div>');

                deletePhone();
            }); 
       });

        function deletePhone(){
            $('.delete_phone').click(function(){
                $(this).parent().parent().remove();
            });
        }


        $( document ).ready(function() {
            deleteAddress();
         $('#add_address').click(function(){
             $('#address').append('<div class="row"><div class="col-md-6"><div class="form-group"><input class="form-control" name="address[]" type="text" id="address" value="" placeholder="Введите адрес"></div></div><div class="col-md-6"><span class="btn btn-danger delete_address">Удалить</span></div></div>');

             deleteAddress();
         }); 
    });

     function deleteAddress(){
         $('.delete_address').click(function(){
             $(this).parent().parent().remove();
         });
     }
        
   </script>
@endpush