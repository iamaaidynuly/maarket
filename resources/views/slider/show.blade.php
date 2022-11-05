@extends('adminlte::layout.main', ['title' => 'Просмотр слайда'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр слайда'])
        @component('adminlte::box')
        <a href="{{ url('/admin/slider') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
        <a href="{{ url('/admin/slider/' . $slider->id . '/edit') }}" title="Редактировать слайд"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

        <form method="POST" action="{{ url('admin/slider' . '/' . $slider->id) }}" accept-charset="UTF-8" style="display:inline">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger btn-sm" title="Delete Slider" onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
        </form>
        <br/>
        <br/>

        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th> Изображение </th>
                        <td> <img src="{{ \Config::get('constants.alias.cdn_url').$slider->image }}" alt="" style="max-width: 500px;"> </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endcomponent
    @endcomponent
@endsection
