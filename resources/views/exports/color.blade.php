<table>
    <thead>
    <tr>
        <th>Наименование RU</th>
        <th>Наименование EN</th>
        <th>Наименование KZ</th>
        <th>Описание RU</th>
        <th>Описание EN</th>
        <th>Описание KZ</th>
        <th>Артикул</th>
        <th>В наличии</th>
        <th>Цена</th>
        <th>Скидка</th>
        <th>ID Бренда</th>
        <th>ID Страны</th>
        <th>ID Категории</th>
        <th>ID Фильтра</th>
        <th>Тип RU</th>
        <th>Тип EN</th>
        <th>Тип KZ</th>
        <th>Размер RU</th>
        <th>Размер EN</th>
        <th>Размер KZ</th>
        <th>Назначение RU</th>
        <th>Назначение EN</th>
        <th>Назначение KZ</th>
        <th>Количество RU</th>
        <th>Количество EN</th>
        <th>Количество KZ</th>

        <th>Цена 1 ID</th>
        <th>Цена 1</th>
        <th>Цена 2 ID</th>
        <th>Цена 2</th>
        <th>Цена 3 ID</th>
        <th>Цена 3</th>
        <th>Цена 4 ID</th>
        <th>Цена 4</th>
        <th>Цена 5 ID</th>
        <th>Цена 5</th>

    </tr>
    </thead>
    <tbody>

    <tr>
        <td>{{ $product->title_ru }}</td>
        <td>{{ $product->title_en }}</td>
        <td>{{ $product->title_kz }}</td>
        <td>{{ $product->desc_ru }}</td>
        <td>{{ $product->desc_en }}</td>
        <td>{{ $product->desc_kz }}</td>
        <td>{{ $product->artikul }}</td>
        <td>{{ $product->stock }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->sale }}</td>
        <td>{{ $product->brand_id }}</td>
        <td>{{ $product->country_id }}</td>
        <td>{{ $product->category_id }}</td>
        <td>{{ $filter_item_id }}</td>
        <td>{{ $feature->type_ru ?? null }}</td>
        <td>{{ $feature->type_en ?? null }}</td>
        <td>{{ $feature->type_kz  ?? null}}</td>
        <td>{{ $feature->size_ru ?? null }}</td>
        <td>{{ $feature->size_en  ?? null}}</td>
        <td>{{ $feature->size_kz ?? null }}</td>
        <td>{{ $feature->purpose_ru ?? null }}</td>
        <td>{{ $feature->purpose_en ?? null }}</td>
        <td>{{ $feature->purpose_kz  ?? null}}</td>
        <td>{{ $feature->quantity_ru ?? null}}</td>
        <td>{{ $feature->quantity_en ?? null}}</td>
        <td>{{ $feature->quantity_kz ?? null}}</td>

        <td>{{ null }}</td>
        <td>{{ null }}</td>
        <td>{{ null }}</td>
        <td>{{ null }}</td>
        <td>{{ null }}</td>
        <td>{{ null }}</td>
        <td>{{ null }}</td>
        <td>{{ null }}</td>
        <td>{{ null }}</td>
        <td>{{ null }}</td>
    </tr>
    </tbody>
</table>
