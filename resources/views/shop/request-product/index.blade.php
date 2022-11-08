@extends('adminlte::layout.main', ['title' => 'Товары в модерации'])

@section('content')

    @component('adminlte::page', ['title' => 'Товары в модерации'])
        @component('adminlte::box')
            @include('flash-message')
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('shop_request_products.create') }}" class="btn btn-success btn-sm"
                       title="Добавить продукт">
                        <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                    </a>
                </div>
            </div>
            <div id="for_sort" class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название Ru</th>
                        <th>Артикул</th>
                        <th>Цена</th>
                        <th>Статус</th>
                        <th>Деиствия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requestProducts as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>
                                @if(isset($item->getTitle))
                                    {{ $item->getTitle->ru }}
                                @else
                                    {{ 'Заголовок отсутствует' }}
                                @endif
                            </td>
                            <td>{{ $item->artikul }}</td>
                            <td>{{ $item->price }}</td>
                            <td>
                                @if($item->status == \App\Models\ShopRequestProduct::STATUS_IN_PROCESS)
                                    В процессе
                                @elseif($item->status = \App\Models\ShopRequestProduct::STATUS_ACCEPTED)
                                    Принято
                                @else
                                    Отклонено
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('shop_request_products.edit', $item->id) }}"
                                   title="Редактировать продукт">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                              aria-hidden="true"></i> Редактировать
                                    </button>
                                </a>

                                <form method="POST" action="{{ route('shop_request_products.destroy', $item->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить страну"
                                            onclick="return confirm(&quot;Подтвердите удаление&quot;)"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i> Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrapper"> {{ $requestProducts->links('pagination::bootstrap-4') }} </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
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
                        console.log(data)
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
    <script>
        $(function () {
            $("#for_sort tbody").sortable({
                cursor: "move",
                placeholder: "sortable-placeholder",
                update: function (event, ui) {
                    $(".table tbody tr").each((item, i) => {
                        $(i).find('td:eq(0)').html(item + 1)
                        let position = $(i).find('td:eq(0)').data('id')
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: 'POST',
                            url: `/admin/product/position/${position}/update`,
                            data: {position: item + 1}
                        })
                            .done(function (msg) {

                            });
                    });
                },
                helper: function (e, tr) {
                    var $originals = tr.children();
                    var $helper = tr.clone();
                    $helper.children().each(function (index) {

                        // Set helper cell sizes to match the original sizes
                        $(this).width($originals.eq(index).width());
                    });
                    return $helper;
                }
            }).disableSelection();


        });
    </script>
@endpush
