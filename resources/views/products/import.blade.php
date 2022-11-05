@extends('adminlte::layout.main', ['title' => 'Загрузить Excel'])

@section('content')
    
    @component('adminlte::page', ['title' => 'Загрузить Excel'])
        @component('adminlte::box')
            @include('flash-message')
            <form class="form-horizontal" action="{{ route('import_excel') }}" method="post" enctype="multipart/form-data" style="border-bottom:1px solid #d3d3d3; margin-bottom:20px;padding-bottom:10px;">
                <div class="row">
                    <div class="col-md-3">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control form-control-sm" type="file"  name="file">
                          </div>
                    </div>
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-success" value="Загрузить">
                    </div>
                </div>
            </form>
            <div class="card-body">
                <a href="{{url('/admin/export/export-excel')}}" class="btn btn-info btn-sm"><i class="fa fa-download" aria-hidden="true"></i> Скачать образец</a>
            </div>
        @endcomponent
    @endcomponent
@endsection