@extends('adminlte::layout.main', ['title' => 'Редактировать'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактировать'])
    @component('adminlte::box')

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

            <div class="col-md-12">
                <form method="POST" action="{{ url('/admin/contacts/' . $contact->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
    
                    @include ('contacts.form', ['formMode' => 'edit'])
    
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
        
   </script>
@endpush
