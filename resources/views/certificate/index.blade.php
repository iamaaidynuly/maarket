@extends('adminlte::layout.main', ['title' => 'Сертификаты'])

@section('content')
    @component('adminlte::page', ['title' => 'Сертификаты'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{route('certificates.create')}}" class="btn btn-success btn-sm" title="Добавить">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>

            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Картинка</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($certificates as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{url("$item->image")}}" width="200px" height="150px">
                            </td>
                            <td>
                                <form method="POST" action="{{ route('certificates.destroy', $item->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить"
                                            onclick="return confirm(&quot;Подтвердите удаление?&quot;)"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endcomponent
    @endcomponent
@endsection
