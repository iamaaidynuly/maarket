@extends('adminlte::layout.main', ['title' => 'Просмотр'])

@section('content')
    @component('adminlte::page', ['title' => 'Просмотр'])
        @component('adminlte::box')
            <a href="{{ url('/admin/contacts') }}" title="Назад">
                <button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад
                </button>
            </a>
            <a href="{{ url('/admin/contacts/' . $contact->id . '/edit') }}" title="Редактировать">
                <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    Редактировать
                </button>
            </a>

            <form method="POST" action="{{ url('admin/contacts' . '/' . $contact->id) }}" accept-charset="UTF-8"
                  style="display:inline">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit" class="btn btn-danger btn-sm" title="Удалить"
                        onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i class="fa fa-trash-o"
                                                                                      aria-hidden="true"></i> Удалить
                </button>
            </form>
            <br/>
            <br/>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            Контент RU
                        </th>
                        </th>
                    </thead>
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $contact->id }}</td>
                    </tr>
                    <tr>
                        <th> Заголовок</th>
                        <td> {{ isset($contact->title) ?  $contact->getTitle->ru : null }} </td>
                    </tr>
                    <tr>
                        <th> Описание</th>
                        <td> {{ isset($contact->description) ? $contact->getDescription->ru : null }} </td>
                    </tr>
                    <tr>
                        <th> Адрес</th>
                        <td> {{ isset($contact->address) ? $contact->getAddress : null }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            Контент EN
                        </th>
                        </th>
                    </thead>
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $contact->id }}</td>
                    </tr>
                    <tr>
                        <th> Заголовок</th>
                        <td> {{ isset($contact->title) ? $contact->getTitle->en : null }} </td>
                    </tr>
                    <tr>
                        <th> Описание</th>
                        <td> {{ isset($contact->description) ? $contact->getDescription->en : null }} </td>
                    </tr>
                    </tr>
                    <tr>
                        <th> Адрес</th>
                        <td> {{  isset($contact->address) ? $contact->getAddress : null }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            Контент KZ
                        </th>
                        </th>
                    </thead>
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $contact->id }}</td>
                    </tr>
                    <tr>
                        <th> Заголовок</th>
                        <td> {{  isset($contact->title) ? $contact->getTitle->kz : null }} </td>
                    </tr>
                    <tr>
                        <th> Описание</th>
                        <td> {{  isset($contact->title) ? $contact->getDescription->kz : null}} </td>
                    </tr>
                    </tr>
                    <tr>
                        <th> Адрес</th>
                        <td> {{   isset($contact->title) ? $contact->getAddress : null }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th> Почта</th>
                        <td> {{$contact->email}} </td>
                    </tr>
                    <tr>
                        <th> Whats_app</th>
                        <td>{{$contact->whats_app}} </td>
                    </tr>
                    <tr>
                        <th> Telegram</th>
                        <td> {{$contact->telegram }}</td>
                    </tr>
                    <tr>
                        <th> Instagram</th>
                        <td>{{$contact->instagram }}</td>
                    </tr>
                    <tr>
                        <th> VK</th>
                        <td>{{$contact->vk }}</td>
                    </tr>
                    <tr>
                        <th> Facebook</th>
                        <td>{{$contact->facebook }}</td>
                    </tr>
                    <tr>
                        <th> Номер телефона</th>
                        <td>
                            @foreach(unserialize($contact->phone_number) as $item)
                                {{ $item }} <br>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endcomponent
    @endcomponent
@endsection
