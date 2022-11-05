@if(request('parent_id'))
    <?php $text = 'Подкатегории ' . $parent->getTitle->ru; ?>
@else
    <?php $text = 'Категории'; ?>
@endif

@extends('adminlte::layout.main', ['title' => $text])

@section('content')

    @component('adminlte::page', ['title' => $text])
        @component('adminlte::box')
            @include('flash-message')
            @if(request('parent_id'))
                <a href="{{ url('/admin/category') }}" class="btn btn-primary btn-sm">Назад</a>
            @endif
            <a href="{{ url('/admin/category/create') }}@if(request('parent_id')){{'?parent_id='.request('parent_id')}}@endif"
               class="btn btn-success btn-sm" title="Добавить категорию">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>
            <br/>
            <br/>
            <div @if(!request('parent_id')) id="for_sort" @endif  class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Наименование</th>
                        @if(!request('parent_id'))
                            <th>Подкатегории</th>
                        @endif
                        <th>Настройка SEO</th>
                        <th>Деиствия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($category as $item)
                        <tr>
                            <td data-id="{{$item->id}}">{{ $item->id }}</td>
                            <td>{{ $item->getTitle->ru }}</td>
                            @if(!request('parent_id'))
                                <td><a href="{{url('/admin/category?parent_id=').$item->id}}">{{ 'Редактировать' }}</a>
                                </td>
                            @endif
                            <td><a href="/admin/category/seo/{{ $item->id }}" class="btn btn-info">Заполнить SEO</a>
                            </td>
                            <td>
                                <a href="{{ url('/admin/category/' . $item->id) }}@if(request('parent_id')){{'?parent_id='.request('parent_id')}}@endif"
                                   title="Просмотр категории">
                                    <button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                        Просмотр
                                    </button>
                                </a>
                                <a href="{{ url('/admin/category/' . $item->id . '/edit') }}@if(request('parent_id')){{'?parent_id='.request('parent_id')}}@endif"
                                   title="Редактировать категорию">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                              aria-hidden="true"></i> Редактирование
                                    </button>
                                </a>

                                <form method="POST" action="{{ url('/admin/category' . '/' . $item->id) }}"
                                      accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить категорию"
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
                    class="pagination-wrapper"> {!! $category->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
        @endcomponent
    @endcomponent
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
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
                            url: `/admin/category/position/${position}/update`,
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
