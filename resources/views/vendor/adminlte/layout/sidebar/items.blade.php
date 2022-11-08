<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">Основное меню</li>
    @if(auth()->user())
        <li>
            <a href="/admin">
                <i class="fa fa-home"></i> <span>Главная</span>
            </a>
        </li>
        {{-- <li><a href="/admin/about-us-block"><i class="fa fa-info"></i> <span>О нас</span></a></li> --}}
        <li class="treeview">
            <a href="#">
                <i class="fa fa-share"></i> <span>Страницы</span>
            </a>
            <ul class="treeview-menu">
                <li><a href="/admin/about-us-block?slug=about"><i class="fa fa-window-restore"></i> О нас</a></li>
                <li><a href="/admin/about-us-block?slug=loyalty"><i class="fa fa-window-restore"></i> Установка </a>
                </li>
                <li><a href="/admin/about-us-block?slug=cooperation"><i class="fa fa-window-restore"></i> Партнеры</a>
                </li>
                <li><a href="/admin/about-us-block?slug=delivery"><i class="fa fa-window-restore"></i> Доставка и
                        самовывоз</a>
                </li>
                <li><a href="/admin/about-us-block?slug=payment"><i class="fa fa-window-restore"></i> Оптовый отдел </a>
                </li>
                {{--            <li><a href="/admin/about-us-block?slug=payment"><i class="fa fa-window-restore"></i> Оплата</a></li>--}}
                {{--            <li><a href="/admin/about-us-block?slug=return"><i class="fa fa-window-restore"></i> Возврат</a></li>--}}
                {{--            <li><a href="/admin/about-us-block?slug=faq"><i class="fa fa-window-restore"></i> Частые вопросы</a></li>--}}
                <li><a href="/admin/about-us-block?slug=contacts"><i class="fa fa-window-restore"></i> Страница Контакты</a>
                </li>
                <li><a href="/admin/about-us-block?slug=offer"><i class="fa fa-window-restore"></i> Оферта</a></li>
                <li><a href="/admin/about-us-block?slug=confidentiality"><i class="fa fa-window-restore"></i>
                        Конфиденциальность</a></li>
                <li><a href="/admin/about-us-block?slug=personal_data"><i class="fa fa-window-restore"></i> Политика
                        обработки персональных данных</a></li>
                <li><a href="/admin/insta"><i class="fa fa-window-restore"></i> Инстаграм</a></li>
                <li><a href="/admin/banner"><i class="fa fa-window-restore"></i> Баннер</a></li>
                <li><a href="{{route('certificates.index')}}"><i class="fa fa-window-restore"></i> Сертификаты </a></li>
                {{--            <li><a href="/admin/about-us-block?slug=promocode"><i class="fa fa-window-restore"></i> Промокод</a></li>--}}
            </ul>
        </li>

        <li><a href="/admin/slider"><i class="fa fa-picture-o"></i> <span>Слайдер</span></a></li>
        <li><a href="/admin/brands"><i class="fa fa-tags"></i> <span>Бренды</span></a></li>
        <li><a href="/admin/country"><i class="fa fa-flag"></i> <span>Страны</span></a></li>
        <li><a href="/admin/region"><i class="fa fa-university"></i> <span>Область</span></a></li>
        <li><a href="/admin/city"><i class="fa fa-university"></i> <span>Город доставки</span></a></li>
        <li><a href="/admin/reviews"><i class="fa fa-comments-o"></i> <span>Отзывы</span></a></li>
        <li><a href="/admin/article"><i class="fa fa-flag"></i> <span>Статьи</span></a></li>
        <li><a href="/admin/filters"><i class="fa fa-filter"></i> <span>Фильтры</span></a></li>
        {{--    <li><a href="/admin/size"><i class="fa fa-filter"></i> <span>Размеры</span></a></li>--}}
        {{--    <li><a href="/admin/colors"><i class="fa fa-thumb-tack"></i> <span>Цвета</span></a></li>--}}
        <li><a href="/admin/category"><i class="fa fa-window-restore"></i> <span>Категории</span></a></li>
        <li><a href="/admin/product"><i class="fa fa-archive"></i> <span>Товары</span></a></li>
        <li><a href="{{route('users.index')}}"><i class="fa fa-user"></i> <span>Пользователи</span></a></li>
        <li><a href="{{route('shops.index')}}"><i class="fa fa-user"></i> <span>Магазины</span></a></li>
        <li><a href="/admin/orders"><i class="fa fa-shopping-basket"></i> <span>Заказы</span></a></li>
        <li><a href="/admin/promocode"><i class="fa fa-percent"></i> <span>Промокоды</span></a></li>
        <li><a href="{{ route('funds.index') }}"><i class="fa fa-percent"></i> <span>Акции</span></a></li>
        {{-- <li><a href="/admin/blogs"><i class="fa fa-rss"></i> <span>Блоги</span></a></li>
        <li><a href="/admin/sales-block"><i class="fa fa-percent"></i> <span>Блок акции</span></a></li> --}}
        <li><a href="/admin/contacts"><i class="fa fa-book"></i> <span>Контакты</span></a></li>
        <li><a href="{{ route('deliveries.index') }}"><i class="fa fa-book"></i> <span>Цена доставки</span></a></li>
        <li><a href="{{ route('price-types.index') }}"><i class="fa fa-book"></i> <span>Виды цен</span></a></li>
        <li><a href="{{route('addresses.index')}}"><i class="fa fa-book"></i> <span>Адреса магазинов</span></a></li>
        <li><a href="{{route('news.index')}}"><i class="fa fa-comments-o"></i> <span>Новости</span></a></li>
        <li><a href="/admin/feedback"><i class="fa fa-phone-square"></i> <span>Обратная связь</span></a></li>
        <li><a href="/admin/click"><i class="fa fa-shopping-basket"></i> <span>Купить в один клик</span></a></li>
        <li><a href="/admin/status-types"><i class="fa fa-mouse-pointer"></i> <span>Статусы</span></a></li>
        <li><a href="/admin/mail"><i class="fa fa-line-chart"></i> <span>Рассылка</span></a></li>
        <li><a href="/admin/static-seo"><i class="fa fa-line-chart"></i> <span>Настройка SEO</span></a></li>
    @endif

    @if(isset($magazin))

        <li><a href="{{route('shop.main')}}"><i class="fa fa-home"></i> <span>Главная</span></a></li>
        <li><a href="{{ route('products.index') }}"><i class="fa fa-archive"></i> <span>Товары принятые</span></a></li>
        <li><a href="{{ route('shop_request_products.index') }}"><i class="fa fa-archive"></i> <span>Товары в модерации</span></a></li>
        <li><a href=""><i class="fa fa-shopping-basket"></i> <span>Заказы</span></a></li>


    @endif
    <!-- <li class="header">LABELS</li>
    <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
</ul>
