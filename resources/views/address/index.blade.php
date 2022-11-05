@extends('adminlte::layout.main', ['title' => 'Адреса'])

@section('content')
    @component('adminlte::page', ['title' => 'Адреса'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{route('addresses.create')}}" class="btn btn-success btn-sm" title="Добавить">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>

            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Город</th>
                        <th>Адрес</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($addresses as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \App\Models\City::where('id', $item->city_id)->first()->getTitle->ru }}</td>
                            <td>{{ $item->getTitle->ru }}</td>
                            <td>
                                <a href="{{route('addresses.edit', $item->id)}}" title="Редактировать">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                              aria-hidden="true"></i> Редактировать
                                    </button>
                                </a>

                                <form method="POST" action="{{ route('addresses.destroy', $item->id) }}"
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
