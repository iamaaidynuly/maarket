@extends('adminlte::layout.main', ['title' => 'Выгрузка Excel'])

@section('content')

    @component('adminlte::page', ['title' => 'Выгрузка Excel'])
        @component('adminlte::box')
            @include('flash-message')
            {{-- <a href="{{ url('/admin/export/export-excel_order') }}" class="btn btn-info btn-sm" title="Загрузить Excel">
                <i class="fa fa-cloud-upload" aria-hidden="true"></i> Экспорт
            </a> --}}

            <form class="form-horizontal" action="{{ route('export_excel_order') }}" method="post"
                  enctype="multipart/form-data"
                  style="border-bottom:1px solid #d3d3d3; margin-bottom:20px;padding-bottom:10px;">
                <div class="row">
                    <div class="col-md-3">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control form-control-sm" type="date" name="ot">
                        </div>
                        <div class="mb-3">
                            <input class="form-control form-control-sm" type="date" name="do">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-success" value="Выгрузить">
                    </div>
                </div>
            </form>
        @endcomponent
    @endcomponent
@endsection
