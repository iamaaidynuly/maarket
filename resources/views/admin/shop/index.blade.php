@extends('adminlte::layout.main', ['title' => 'Магазины'])

@section('content')
    @component('adminlte::page', ['title' => 'Магазины'])
        @component('adminlte::box')
            @include('flash-message')
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('shops.create') }}" class="btn btn-success btn-sm" title="Добавить">
                        <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                    </a>
                    <form action="{{route('shops.index')}}" method="get" accept-charset="UTF-8"
                          style="display:inline">
                        {{ csrf_field() }}
                        <input type="text" name="text" id="text" class="form-group">
                        <button type="submit" class="btn btn-info btn-sm">Искать</button>
                    </form>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Логин</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Адрес</th>
                        <th>Город</th>
                        <th>Иконка</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shops as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->getName->ru }}</td>
                            <td>{{ $item->getDescription->ru }}</td>
                            <td>{{ $item->getAddress->ru }}</td>
                            <td>{{ $item->getCity->getTitle->ru }}</td>
                            <td>
                                @if(isset($item->icon))
                                    <img src="{{url("$item->icon")}}" width="150px" height="100px">
                                @endif
                            </td>

                            <td>
                                <form method="POST" action="{{ route('shops.destroy', $item->id)  }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <a class="btn btn-sm btn-primary "
                                       href="{{ route('shops.show',$item->id) }}"><i
                                            class="fa fa-fw fa-eye"></i></a>
                                    <a class="btn btn-sm btn-success"
                                       href="{{ route('shops.edit',$item->id) }}"><i
                                            class="fa fa-fw fa-edit"></i></a>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить бренд"
                                            onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div
                    class="pagination-wrapper"> {!! $shops->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
