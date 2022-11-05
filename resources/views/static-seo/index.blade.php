@extends('adminlte::layout.main', ['title' => 'SEO для статичных страниц'])

@section('content')
    @component('adminlte::page', ['title' => 'SEO для статичных страниц'])
        @component('adminlte::box')
            @include('flash-message')
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Наименование страницы</th><th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staticseo as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    <a href="{{ url('/admin/static-seo/' . $item->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {!! $staticseo->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
