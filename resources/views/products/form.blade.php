<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
    <li class="nav-item active">
        <a class="nav-link active" id="custom-tabs-one-ru-tab" data-toggle="pill" href="#custom-tabs-one-ru" role="tab"
           aria-controls="custom-tabs-one-ru" aria-selected="true">Русский</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-en-tab" data-toggle="pill" href="#custom-tabs-one-en" role="tab"
           aria-controls="custom-tabs-one-en" aria-selected="false">Английский</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-kz-tab" data-toggle="pill" href="#custom-tabs-one-kz" role="tab"
           aria-controls="custom-tabs-one-kz" aria-selected="false">Казахский</a>
    </li>
</ul>

<div class="tab-content" id="custom-tabs-one-tabContent">
    <div class="tab-pane fade active in" id="custom-tabs-one-ru" role="tabpanel"
         aria-labelledby="custom-tabs-one-ru-tab">
        <div class="form-group col-md-12 {{ $errors->has('title.ru') ? 'has-error' : '' }}">
            <label for="title_ru" class="control-label">{{ 'Название Ru' }}</label>
            <input class="form-control" name="title[ru]" type="text" id="title_ru"
                   value="{{ isset($product->title) ? $product->getTitle->ru : old('title.ru') }}" required>
            {!! $errors->first('title.ru', '<p class="help-block">:message</p>') !!}
        </div>

        {{-- <div class="form-group col-md-12 {{ $errors->has('short_description.ru') ? 'has-error' : ''}}">
            <label for="short_description_ru" class="control-label">{{ 'Краткое описание Ru' }}</label>
            <input class="form-control" name="short_description[ru]" type="text" id="short_description_ru"
                value="{{ isset($product->short_description) ? $product->getShort->ru : old('short_description.ru')}}"
                required>
            {!! $errors->first('short_description.ru', '<p class="help-block">:message</p>') !!}
        </div> --}}

        <div class="form-group col-md-12 {{ $errors->has('description.ru') ? 'has-error' : '' }}">
            <label for="description_ru" class="control-label">{{ 'Описание Ru' }}</label>
            <textarea class="form-control" name="description[ru]" id="description_ru" rows="10"
                      required>{{ isset($product->description) ? $product->getDesc->ru : old('description.ru') }}</textarea>
            {!! $errors->first('description.ru', '<p class="help-block">:message</p>') !!}
        </div>

        {{--        <div class="form-group col-md-12 {{ $errors->has('specifications.ru') ? 'has-error' : '' }}">--}}
        {{--            <label for="specifications_ru" class="control-label">{{ 'Состав и Уход Ru' }}</label>--}}
        {{--            <textarea class="form-control" name="specifications[ru]" id="specifications_ru" rows="10"--}}
        {{--                      required>{{ isset($product->specifications) ? $product->getSpec->ru : old('specifications.ru') }}</textarea>--}}
        {{--            {!! $errors->first('specifications.ru', '<p class="help-block">:message</p>') !!}--}}
        {{--        </div>--}}

        {{-- <div class="form-group col-md-12 {{ $errors->has('specifications.ru') ? 'has-error' : ''}}">
            <label for="specifications_ru" class="control-label">{{ 'Характеристики Ru' }}</label>
            <textarea class="form-control" name="specifications[ru]" id="specifications_ru" rows="10"
                required>{{ isset($product->specifications) ? $product->getSpec->ru : old('specifications.ru')}}</textarea>
            {!! $errors->first('specifications.ru', '<p class="help-block">:message</p>') !!}
        </div> --}}

        <div class="form-group col-md-12">
            <h3 class="card-title">Характеристики товара RU</h3>

            <div class="form-group col-md-6">
                <label>Тип</label>
                <input value="{{isset($feature->type) ? $feature->getType->ru : null}}" class="form-control"
                       name="feature_type[ru]">
            </div>
            <div class="form-group col-md-6">
                <label>Назначение</label>
                <input value="{{isset($feature->purpose) ? $feature->getPurpose->ru : null}}" class="form-control"
                       name="feature_purpose[ru]">
            </div>
            <div class="form-group col-md-6">
                <label>Размер</label>
                <input value="{{isset($feature->size) ? $feature->getSize->ru : null}}" class="form-control"
                       name="feature_size[ru]">
            </div>
            <div class="form-group col-md-6">
                <label>Количество</label>
                <input value="{{isset($feature->quantity) ? $feature->getQuantity->ru : null}}" class="form-control"
                       name="feature_quantity[ru]">
            </div>
        </div>

    </div>

    <div class="tab-pane fade" id="custom-tabs-one-en" role="tabpanel" aria-labelledby="custom-tabs-one-en-tab">
        <div class="form-group col-md-12 {{ $errors->has('title.en') ? 'has-error' : '' }}">
            <label for="title_en" class="control-label">{{ 'Название En' }}</label>
            <input class="form-control" name="title[en]" type="text" id="title_en"
                   value="{{ isset($product->title) ? $product->getTitle->en : old('title.en') }}">
            {!! $errors->first('title.en', '<p class="help-block">:message</p>') !!}
        </div>

        {{-- <div class="form-group col-md-12 {{ $errors->has('short_description.en') ? 'has-error' : ''}}">
            <label for="short_description_en" class="control-label">{{ 'Краткое описание En' }}</label>
            <input class="form-control" name="short_description[en]" type="text" id="short_description_en"
                value="{{ isset($product->short_description) ? $product->getShort->en : old('short_description.en')}}">
            {!! $errors->first('short_description.en', '<p class="help-block">:message</p>') !!}
        </div> --}}

        <div class="form-group col-md-12 {{ $errors->has('description.en') ? 'has-error' : '' }}">
            <label for="description_en" class="control-label">{{ 'Описание En' }}</label>
            <textarea class="form-control" name="description[en]" id="description_en" rows="10"
                      required>{{ isset($product->description) ? $product->getDesc->en : old('description.en') }}</textarea>
            {!! $errors->first('description.en', '<p class="help-block">:message</p>') !!}
        </div>

        {{--        <div class="form-group col-md-12 {{ $errors->has('specifications.en') ? 'has-error' : '' }}">--}}
        {{--            <label for="specifications_en" class="control-label">{{ 'Состав и Уход En' }}</label>--}}
        {{--            <textarea class="form-control" name="specifications[en]" id="specifications_en" rows="10"--}}
        {{--                      required>{{ isset($product->specifications) ? $product->getSpec->en : old('specifications.en') }}</textarea>--}}
        {{--            {!! $errors->first('specifications.en', '<p class="help-block">:message</p>') !!}--}}
        {{--        </div>--}}

        {{-- <div class="form-group col-md-12 {{ $errors->has('specifications.en') ? 'has-error' : ''}}">
            <label for="specifications_kz" class="control-label">{{ 'Характеристики en' }}</label>
            <textarea class="form-control" name="specifications[en]" id="specifications_en" rows="10"
                required>{{ isset($product->specifications) ? $product->getSpec->en : old('specifications.en')}}</textarea>
            {!! $errors->first('specifications.en', '<p class="help-block">:message</p>') !!}
        </div> --}}

        <div class="form-group col-md-12">
            <h3 class="card-title">Характеристики товара EN</h3>

            <div class="form-group col-md-6">
                <label>Тип</label>
                <input value="{{isset($feature->type) ? $feature->getType->en : null}}" class="form-control"
                       name="feature_type[en]">
            </div>
            <div class="form-group col-md-6">
                <label>Назначение</label>
                <input value="{{isset($feature->purpose) ? $feature->getPurpose->en : null}}" class="form-control"
                       name="feature_purpose[en]">
            </div>
            <div class="form-group col-md-6">
                <label>Размер</label>
                <input value="{{isset($feature->size) ? $feature->getSize->en : null}}" class="form-control"
                       name="feature_size[en]">
            </div>
            <div class="form-group col-md-6">
                <label>Количество</label>
                <input value="{{isset($feature->quantity) ? $feature->getQuantity->en : null}}" class="form-control"
                       name="feature_quantity[en]">
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="custom-tabs-one-kz" role="tabpanel" aria-labelledby="custom-tabs-one-kz-tab">
        <div class="form-group col-md-12 {{ $errors->has('title.kz') ? 'has-error' : '' }}">
            <label for="title_kz" class="control-label">{{ 'Название Kz' }}</label>
            <input class="form-control" name="title[kz]" type="text" id="title_kz"
                   value="{{ isset($product->title) ? $product->getTitle->kz : old('title.kz') }}">
            {!! $errors->first('title.kz', '<p class="help-block">:message</p>') !!}
        </div>

        {{-- <div class="form-group col-md-12 {{ $errors->has('short_description.kz') ? 'has-error' : ''}}">
            <label for="short_description_kz" class="control-label">{{ 'Краткое описание Kz' }}</label>
            <input class="form-control" name="short_description[kz]" type="text" id="short_description_kz"
                value="{{ isset($product->short_description) ? $product->getShort->kz : old('short_description.kz')}}">
            {!! $errors->first('short_description.kz', '<p class="help-block">:message</p>') !!}
        </div> --}}

        <div class="form-group col-md-12 {{ $errors->has('description.kz') ? 'has-error' : '' }}">
            <label for="description_kz" class="control-label">{{ 'Описание Kz' }}</label>
            <textarea class="form-control" name="description[kz]" id="description_kz" rows="10" required>
                {{ isset($product->description) ? $product->getDesc->kz : old('description.kz') }}
            </textarea>
            {!! $errors->first('description.kz', '<p class="help-block">:message</p>') !!}
        </div>

        {{--        <div class="form-group col-md-12 {{ $errors->has('specifications.kz') ? 'has-error' : '' }}">--}}
        {{--            <label for="specifications_kz" class="control-label">{{ 'Состав и Уход Kz' }}</label>--}}
        {{--            <textarea class="form-control" name="specifications[kz]" id="specifications_kz" rows="10" required>--}}
        {{--                {{ isset($product->specifications) ? $product->getSpec->kz : old('specifications.kz') }}--}}
        {{--            </textarea>--}}
        {{--            {!! $errors->first('specifications.kz', '<p class="help-block">:message</p>') !!}--}}
        {{--        </div>--}}

        {{-- <div class="form-group col-md-12 {{ $errors->has('specifications.en') ? 'has-error' : ''}}">
            <label for="specifications_kz" class="control-label">{{ 'Характеристики en' }}</label>
            <textarea class="form-control" name="specifications[en]" id="specifications_en" rows="10"
                required>{{ isset($product->specifications) ? $product->getSpec->en : old('specifications.en')}}</textarea>
            {!! $errors->first('specifications.en', '<p class="help-block">:message</p>') !!}
        </div> --}}

        <div class="form-group col-md-12">
            <h3 class="card-title">Характеристики товара KZ</h3>

            <div class="form-group col-md-6">
                <label>Тип</label>
                <input value="{{isset($feature->type) ? $feature->getType->kz : null}}" class="form-control"
                       name="feature_type[kz]">
            </div>
            <div class="form-group col-md-6">
                <label>Назначение</label>
                <input value="{{isset($feature->purpose) ? $feature->getPurpose->kz : null}}" class="form-control"
                       name="feature_purpose[kz]">
            </div>
            <div class="form-group col-md-6">
                <label>Размер</label>
                <input value="{{isset($feature->size) ? $feature->getSize->kz : null}}" class="form-control"
                       name="feature_size[kz]">
            </div>
            <div class="form-group col-md-6">
                <label>Количество</label>
                <input value="{{isset($feature->quantity) ? $feature->getQuantity->kz : null}}" class="form-control"
                       name="feature_quantity[kz]">
            </div>
        </div>

    </div>
</div>

<div class="form-group col-md-6 {{ $errors->has('artikul') ? 'has-error' : '' }}">
    <label for="artikul" class="control-label">{{ 'Артикул' }}</label>
    <input class="form-control" name="artikul" type="text" id="artikul"
           value="{{ isset($product->artikul) ? $product->artikul : old('artikul') }}" required>
    {!! $errors->first('artikul', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('stock') ? 'has-error' : '' }}">
    <label for="stock" class="control-label">{{ 'Наличие' }}</label>
    <select name="stock" id="stock" class="form-control">
        <option value="1" @if (isset($product->stock) && $product->stock == 1) selected @endif>В наличии</option>
        <option value="0" @if (isset($product->stock) && $product->stock == 0) selected @endif>Нет в наличии</option>
        <option value="2" @if (isset($product->stock) && $product->stock == 2) selected @endif>Скоро в продаже</option>
    </select>
    {!! $errors->first('stock', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6 {{ $errors->has('price') ? 'has-error' : '' }}">
    <label for="price" class="control-label">{{ 'Цена' }}</label>
    <input class="form-control" name="price" type="number" id="price"
           value="{{ isset($product->price) ? $product->price : old('price') }}" required>
    {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('sale') ? 'has-error' : '' }}">
    <label for="sale" class="control-label">{{ 'Скидка (в %)' }}</label>
    <input class="form-control" name="sale" type="number" id="sale"
           value="{{ isset($product->sale) ? $product->sale : old('sale') }}">
    {!! $errors->first('sale', '<p class="help-block">:message</p>') !!}
</div>

{{--@if ($colors)--}}
{{--    <div class="form-group col-md-6 {{ $errors->has('brand_id') ? 'has-error' : '' }} ">--}}
{{--        <label for="colors" class="control-label">{{ 'Цвет (после добавления цвета, сохраните товар и укажите--}}
{{--        наличие)' }}</label>--}}
{{--        <select name="colors[]" id="colors" class="form-control js-example-basic-multiple" multiple>--}}
{{--            @foreach ($colors as $item)--}}
{{--                <option value="{{ $item->id }}" @if (in_array($item->id, $colors_arr)) selected @endif>--}}
{{--                    {{ $item->title }} <span style="height: 15px;width:15px;background:{{ $item->code }}"></span>--}}
{{--                </option>--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--        {!! $errors->first('colors', '<p class="help-block">:message</p>') !!}--}}
{{--    </div>--}}
{{--@endif--}}

@if ($brands)
    <div class="form-group col-md-6 {{ $errors->has('brand_id') ? 'has-error' : '' }}">
        <label for="brand_id" class="control-label">{{ 'Бренд' }}</label>
        <select name="brand_id" id="brand_id" class="form-control js-example-basic-single" required>
            <option value="">Выберите бренд</option>
            @foreach ($brands as $item)
                <option value="{{ $item->id }}"
                        @if (isset($product) && $item->id == $product->brand_id) selected @endif>
                    {{ $item->title }}</option>
            @endforeach
        </select>
        {!! $errors->first('brand_id', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group col-md-6 {{ $errors->has('brand_items') ? 'has-error' : '' }}">
        <label for="brand_items" class="control-label">{{ 'Коллекции' }}</label>
        <select name="brand_items" id="brand_items" class="form-control js-example-basic-single" required>
            @if (isset($brand_items))
                @foreach ($brand_items as $item)
                    <option value="{{ $item->id }}"
                            @if (isset($product) && $item->id == $product->brand_items_id) selected @endif>
                        {{ $item->title }}</option>
                @endforeach
            @else
                @include('products.brand_items_option')
            @endif

        </select>
        {!! $errors->first('brand_items', '<p class="help-block">:message</p>') !!}
    </div>
@endif

@if ($category)
    <div class="form-group col-md-6 {{ $errors->has('category_id') ? 'has-error' : '' }}">
        <label for="category_id" class="control-label">{{ 'Категория' }}</label>
        <select name="category_id" id="category_id" class="form-control js-example-basic-single" required>
            <option value="">Выберите категорию</option>
            @foreach ($category as $item)
                <option value="{{ $item->id }}" @if ($item->getChilds->count() > 0) disabled @endif
                @if (isset($product) && $item->id == $product->category_id) selected @endif><b>{{ $item->title }}</b>
                </option>
                @if ($item->getChilds->count() > 0)
                    @foreach ($item->getChilds as $child)
                        <option value="{{ $child->id }}"
                                @if (isset($product) && $child->id == $product->category_id) selected @endif>
                            ---{{ $child->getTitle->ru }}</option>
                    @endforeach
                @endif
            @endforeach
        </select>
        {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
    </div>
@endif

<div class="form-group col-md-6 {{ $errors->has('filters') ? 'has-error' : '' }}">
    <label for="filters" class="control-label">{{ 'Фильтры' }}</label>
    <select name="filters[]" id="filters" class="form-control js-example-basic-multiple" multiple>
        @if (isset($filters))
            @foreach ($filters as $item)
                <optgroup label="{{ $item->getFilter->getTitle->ru }}">
                    @if ($item->getFilter->getItems->count() > 0)
                        @foreach ($item->getFilter->getItems as $key => $value)
                            <option value="{{ $value->id }}" @if (in_array($value->id, $filters_arr)) selected @endif>
                                {{ $value->getTitle->ru }}</option>
                        @endforeach
                    @endif
                </optgroup>
            @endforeach
        @else
            @include('products.filters_option')
        @endif

    </select>
    {!! $errors->first('filters', '<p class="help-block">:message</p>') !!}
</div>

@if ($country)
    <div class="form-group col-md-12 {{ $errors->has('country_id') ? 'has-error' : '' }} ">
        <label for="country_id" class="control-label">{{ 'Страна производства' }}</label>
        <select name="country_id" id="country_id" class="form-control js-example-basic-single" required>
            @foreach ($country as $item)
                <option value="{{ $item->id }}"
                        @if (isset($product) && $item->id == $product->country_id) selected @endif>
                    {{ $item->title }}</option>
            @endforeach
        </select>
        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
@endif

{{--<div class="form-group col-md-6 {{ $errors->has('size_id') ? 'has-error' : '' }} ">--}}
{{--    <label for="size_id" class="control-label">{{ 'Тип размера' }}</label>--}}
{{--    <select name="size_id" id="size_id" class="form-control js-example-basic-single" required>--}}
{{--        <option value="">Выберите тип размера</option>--}}
{{--        @foreach ($size as $item)--}}
{{--            <option value="{{ $item->id }}" @if (isset($product) && $item->id == $product->size_id) selected @endif>--}}
{{--                {{ $item->title }}</option>--}}
{{--        @endforeach--}}
{{--    </select>--}}
{{--    {!! $errors->first('size_id', '<p class="help-block">:message</p>') !!}--}}
{{--</div>--}}

{{--<div class="form-group col-md-6 {{ $errors->has('size_items') ? 'has-error' : '' }}">--}}
{{--    <label for="size_items" class="control-label">{{ 'Размеры (после добавления размера, сохраните товар и укажите--}}
{{--        наличие)' }}</label>--}}
{{--    <select name="size_items[]" id="size_items" class="form-control js-example-basic-multiple" multiple>--}}
{{--        @if (isset($size_items))--}}
{{--            @foreach ($size_items as $item)--}}
{{--                <option value="{{ $item->id }}" @if (in_array($item->id, $size_arr)) selected @endif>--}}
{{--                    {{ $item->title }}</option>--}}
{{--            @endforeach--}}
{{--        @else--}}
{{--            @include('products.size_items_option')--}}
{{--        @endif--}}

{{--    </select>--}}
{{--    {!! $errors->first('size_items', '<p class="help-block">:message</p>') !!}--}}
{{--</div>--}}

<div class="card col-md-6">
    <div class="card-header">
        <h3 class="card-title">Количество товара</h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Цвет</th>
                <th>Размер</th>
                <th>Количество</th>
            </tr>
            </thead>
            <tbody>
            @php
                use App\Models\Quantity;
            @endphp

            @foreach ($colors as $color)
                @if (in_array($color->id, $colors_arr))
                    @foreach ($size_items as $size)
                        @if (in_array($size->id, $size_arr))
                            @php
                                $quantity = Quantity::where('product_id', $product->id)
                                ->where('size_id', $size->id)
                                ->where('color_id', $color->id)
                                ->first();
                            @endphp
                            <tr>

                                <td>{{ $color->title }}</td>
                                <td>{{ $size->title }}</td>
                                <td><input type="hidden" name="q_colors[]" value="{{ $color->id }}">
                                    <input type="hidden" name="q_sizes[]" value="{{ $size->id }}">
                                    <input class="form-control" name="quantity[]" type="number" id="quantity"
                                           value="@if ($quantity){{ $quantity->quantity }}@else{{('0')}}@endif"
                                           required>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- @foreach ($quantity_items as $quantity)
            <tr>
                <td>{{ $colors[$quantity->color_id]->title }}</td>
                <td>{{ $size_items[$quantity->size_id]->title }}</td>
                <td><input type="hidden" name="q_colors[]" value="{{ $quantity->color_id }}">
                    <input type="hidden" name="q_sizes[]" value="{{ $quantity->size_id }}">
                    <input class="form-control" name="quantity[]" type="number" id="quantity"
                        value="{{ $quantity->quantity }}" required>
                </td>
            </tr>
            @endforeach --}}

            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12" style="padding: 0 !important">
    <div class="form-group col-md-6 {{ $errors->has('main_image') ? 'has-error' : '' }}">
        <label for="main_image" class="control-label">{{ 'Главное изображение' }}</label>
        <input class="form-control" name="main_image" type="file" id="main_image"
               value="{{ isset($product->main_image) ? $product->main_image : '' }}">
        {!! $errors->first('main_image', '<p class="help-block">:message</p>') !!}
        @if (isset($product->main_image))
            <img src="{{ \Config::get('constants.alias.cdn_url') . $product->main_image }}" alt=""
                 style="max-width: 300px;">
        @endif
    </div>
</div>


<div class="form-group col-md-12 {{ $errors->has('images') ? 'has-error' : '' }}">
    <label for="images" class="control-label">{{ 'Изображении' }}</label>
    <input type="file" name="images[]" id="images" class="form-control" multiple>
    {!! $errors->first('images', '<p class="help-block">:message</p>') !!}
    @if (isset($images))
        <br><br>
        <div class="row">
            @foreach ($images as $item)
                <div class="col-md-3">
                    <div class="img-wrapper" style="position:reklative">
                        <img src="{{ \Config::get('constants.alias.cdn_url') }}/{{ $item->image }}" alt=""
                             style="max-width:100%">
                        <span data-id="{{ $item->id }}" class="btn btn-danger delete-img-product"
                              style="position:absolute; top:0; right:0">Удалить</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<br>
<br>
<div class="card col-md-6">
    <div class="card-header">
        <h3 class="card-title">Продавцы товара </h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Магазин</th>
                <th>Цена</th>
                <th>В наличии</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($shopProducts as $product)
                    <td>{{ $product->shop->getName->ru }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->available }}</td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
    </div>
</div>
