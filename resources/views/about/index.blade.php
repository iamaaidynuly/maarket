{{--@if($slug== 'about')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'О нас'])--}}
{{--    <?php--}}
{{--    $pageTitle = "О нас"--}}
{{--    ?>--}}
{{--@elseif($slug == 'loyalty')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Установка'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Установка'--}}
{{--    ?>--}}
{{--@elseif($slug == 'cooperation')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Сотрудничество'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Сотрудничество'--}}
{{--    ?>--}}
{{--@elseif($slug == 'delivery')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Доставка и самовывоз'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Доставка и самовывоз'--}}
{{--    ?>--}}
{{--@elseif($slug == 'payment')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Оптовый отдел'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Оптовый отдел'--}}
{{--    ?>--}}
{{--@elseif($slug == 'return')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Возврат'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Возврат'--}}
{{--    ?>--}}
{{--@elseif($slug == 'faq')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Частые вопросы'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Частые вопросы'--}}
{{--    ?>--}}
{{--@elseif($slug == 'banner')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Баннер'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Баннер'--}}
{{--    ?>--}}
{{--@elseif($slug == 'promocode')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Промокод'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Промокод'--}}
{{--    ?>--}}
{{--@elseif($slug == 'contacts')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Страница Контакты'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Страница Контакты'--}}
{{--    ?>--}}
{{--@elseif($slug == 'offer')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Оферта'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Оферта'--}}
{{--    ?>--}}
{{--@elseif($slug == 'confidentiality')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Конфиденциальность'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Конфиденциальность'--}}
{{--    ?>--}}
{{--@elseif($slug == 'personal_data')--}}
{{--    @extends('adminlte::layout.main', ['title' => 'Политика обработки персональных данных'])--}}
{{--    <?php--}}
{{--    $pageTitle = 'Политика обработки персональных данных'--}}
{{--    ?>--}}
{{--@endif--}}
@extends('adminlte::layout.main', ['title' => 'О нас'])
@section('content')
    @component('adminlte::page', ['title' => 'О нас'])
        @component('adminlte::box')
            @include('flash-message')
            <a href="{{ route('about-us-block.create') }}" class="btn btn-success btn-sm" title="Добавить">
                <i class="fa fa-plus" aria-hidden="true"></i> Добавить
            </a>

            <br/>
            <br/>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Заголовок</th>
                        <th>Описание</th>
                        <th>Картинка</th>
                        <th>Картинка моб</th>
                        <th>Деиствия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($abouts as $about)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $about->getTitle->ru }}</td>
                            <td>{{ $about->getDescription->ru }}</td>
                            <td>
                                <img src="{{ \Config::get('constants.alias.cdn_url').$about->image }}" alt=""
                                     style="max-width: 100px;">
                            </td>
                            <td>
                                <img src="{{ \Config::get('constants.alias.cdn_url').$about->image_mobile }}" alt=""
                                     style="max-width: 100px;">
                            </td>
                            <td>
                                <a href="{{ route('about-us-block.edit', $about->id) }}" title="Редактировать">
                                    <input type="hidden" name="slug" value="{{$slug}}">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                                                              aria-hidden="true"></i> Редактировать
                                    </button>
                                </a>

                                <form method="POST" action="{{ route('about-us-block.destroy', $about->id) }}"
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
