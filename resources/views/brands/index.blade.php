@extends('adminlte::layout.main', ['title' => 'Бренды'])

@section('content')
    @component('adminlte::page', ['title' => 'Бренды'])
        @component('adminlte::box')
            @include('flash-message')

            <a href="{{ url('/admin/brands/create') }}" class="btn btn-success btn-sm" title="Добавить">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Наименование</th>
                        <th>Логотип</th>
                        <th>Популярный</th>
                        <th>Настройка SEO</th>
                        <th>Деиствия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($brands as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$item->id}}</td>
                            <td>{{ $item->getTitle->ru }}</td>
                            <td><img src="{{ \Config::get('constants.alias.cdn_url').$item->image }}" alt=""
                                     style="max-width: 100px;"></td>
                            <td>
                                <label class="checkbox-google">
                                    <input type="checkbox" class="status_toggle status_update" data-id="{{$item->id}}"
                                           data-type="brand" @if($item->popular == 1)
                                        {{ 'checked' }}
                                        @endif>
                                    <span class="checkbox-google-switch"></span>
                                </label>
                            </td>
                            <td><a href="/admin/brands/seo/{{ $item->id }}" class="btn btn-info">Заполнить SEO</a></td>
                            <td>
                                <a href="{{ url('/admin/brand-items/' . $item->id) }}" title="Просмотр фильтра">
                                    <button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                        Просмотр значений
                                    </button>
                                </a>
                            <!-- <a href="{{ url('/admin/brands/' . $item->id) }}" title="Посмотреть бренд"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a> -->
                                <a href="{{ url('/admin/brands/' . $item->id . '/edit') }}" title="Редактировать бренд">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                              aria-hidden="true"></i> Редактировать
                                    </button>
                                </a>

                                <form method="POST" action="{{ url('/admin/brands' . '/' . $item->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
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
                    class="pagination-wrapper"> {!! $brands->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
@push('styles')
    <style>
        .checkbox-google {
            display: inline-block;
            height: 28px;
            line-height: 28px;
            margin-right: 10px;
            position: relative;
            vertical-align: middle;
            font-size: 14px;
            user-select: none;
        }

        .checkbox-google .checkbox-google-switch {
            display: inline-block;
            width: 36px;
            height: 14px;
            border-radius: 20px;
            position: relative;
            top: 6px;
            vertical-align: top;
            background: #9f9f9f;
            transition: .2s;
        }

        .checkbox-google .checkbox-google-switch:before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            position: absolute;
            top: -3px;
            left: -1px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
            transition: .15s;
        }

        .checkbox-google input[type=checkbox] {
            display: block;
            width: 0;
            height: 0;
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .checkbox-google input[type=checkbox]:checked + .checkbox-google-switch {
            background: #9ABEF7;
        }

        .checkbox-google input[type=checkbox]:checked + .checkbox-google-switch:before {
            background: #1a73e8;
            transform: translateX(18px);
        }


        /* Hover */

        .checkbox-google input[type="checkbox"]:not(:disabled) + .checkbox-google-switch {
            cursor: pointer;
            border-color: rgba(0, 0, 0, .3);
        }


        /* Active/Focus */

        .checkbox-google input[type="checkbox"]:not(:disabled):active + .checkbox-google-switch:before,
        .checkbox-google input[type="checkbox"]:not(:disabled):focus + .checkbox-google-switch:before {
            animation: checkbox-active-on 0.5s forwards linear;
        }

        @keyframes checkbox-active-on {
            0% {
                box-shadow: 0 0 0 0 rgba(212, 212, 212, 0);
            }
            99% {
                box-shadow: 0 0 0 10px rgba(212, 212, 212, 0.5);
            }
        }

        .checkbox-google input[type="checkbox"]:not(:disabled):checked:active + .checkbox-google-switch:before,
        .checkbox-google input[type="checkbox"]:not(:disabled):checked:focus + .checkbox-google-switch:before {
            animation: checkbox-active-off 0.5s forwards linear;
        }

        @keyframes checkbox-active-off {
            0% {
                box-shadow: 0 0 0 0 rgba(154, 190, 247, 0);
            }
            99% {
                box-shadow: 0 0 0 10px rgba(154, 190, 247, 0.5);
            }
        }


        /* Disabled */

        .checkbox-google input[type=checkbox]:disabled + .checkbox-google-switch {
            filter: grayscale(60%);
            border-color: rgba(0, 0, 0, .1);
        }

        .checkbox-google input[type=checkbox]:disabled + .checkbox-google-switch:before {
            background: #eee;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $('.status_update').click(function (e) {
            let dataId = $(this).attr('data-id')
            let dataType = $(this).attr('data-type')
            if ($(this).prop('checked')) {
                $.ajax({
                    method: "POST",
                    url: "/admin/api-update-status",
                    data: {_token: $('meta[name="csrf-token"]').attr('content'), id: dataId, type: dataType, status: 1},
                    success: () => {
                    }
                })
            } else {
                $.ajax({
                    method: "POST",
                    url: "/admin/api-update-status",
                    data: {_token: $('meta[name="csrf-token"]').attr('content'), id: dataId, type: dataType, status: 0},
                    success: () => {
                    }
                })
            }
        });

    </script>
@endpush
