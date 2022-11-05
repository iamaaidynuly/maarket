@extends('adminlte::layout.main', ['title' => 'Просмотр категории'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр категории'])
        @component('adminlte::box')
    
        <a href="{{ url('/admin/category') }}@if(request('parent_id')){{'?parent_id='.request('parent_id')}}@endif" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
        <a href="{{ url('/admin/category/' . $category->id . '/edit') }}@if(request('parent_id')){{'?parent_id='.request('parent_id')}}@endif" title="Редактировать категорию"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

        <form method="POST" action="{{ url('admin/category' . '/' . $category->id) }}" accept-charset="UTF-8" style="display:inline">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger btn-sm" title="Удалить категорию" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
        </form>
        <br/>
        <br/>

        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th>ID</th><td>{{ $category->id }}</td>
                    </tr>
                    <tr><th> Наименование Ru </th><td> {{ $category->getTitle->ru }} </td></tr>
                    <tr><th> Наименование En </th><td> {{ $category->getTitle->en }} </td></tr>
                    <tr><th> Наименование Kz </th><td> {{ $category->getTitle->kz }} </td></tr>
                    <tr><th> Описание Ru </th><td> {{ $category->getContent->ru }} </td></tr>
                    <tr><th> Описание En </th><td> {{ $category->getContent->en }} </td></tr>
                    <tr><th> Описание Kz </th><td> {{ $category->getContent->kz }} </td></tr>
    
                    <tr><th> Изображение </th><td> <img src="{{ \Config::get('constants.alias.cdn_url').$category->image }}" alt=""> </td></tr>
                    
                    <tr>
                        <th>
                            Фильтры
                        </th>
                        <td>
                            @foreach($category->getFilters as $item)
                                {{$item->getFilter->getTitle->ru}} <br>                                
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endcomponent
    @endcomponent
@endsection
