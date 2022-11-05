@extends('adminlte::layout.main', ['title' => 'Купить в один клик'])

@section('content')
    @component('adminlte::page', ['title' => 'Купить в один клик'])
    @component('adminlte::box')
        @include('flash-message')
    
            {{-- <a href="{{ url('/admin/click/create') }}" class="btn btn-success btn-sm" title="Добавить">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a> --}}
            <br/>
            <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Номер телефона</th><th>Наименование продукта</th><th>Деиствия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($click as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->phone_number }}</td><td>{{ $item->getProducts->getTitle->ru }}</td>
                                        <td>
                                            <a href="{{ url('/admin/click/' . $item->id) }}" title="Посмотреть"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Посмотреть</button></a>
                                            {{-- <a href="{{ url('/admin/click/' . $item->id . '/edit') }}" title="Edit Click"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/click' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Click" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $click->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

        @endcomponent
    @endcomponent
@endsection