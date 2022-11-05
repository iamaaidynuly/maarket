<table>
    <thead>
    <tr>
        <th>Категория</th>
        <th>Подкатегория</th>
        <th>ID категории</th>
        <th>Фильтр</th>
        <th>Значение фильтра</th>
        <th>ID фильтра</th>
    </tr>
    </thead>
    <tbody>
        
    @foreach($data as $item)
        <tr>
            <td>{{ $item['parent_title'] }}</td>
            <td>{{ $item['child_title'] }}</td>
            <td>{{ $item['id_cat'] }}</td>
            <td>{{ $item['filter_name'] }}</td>
            <td>{{ $item['item_name'] }}</td>
            <td>{{ $item['item_filter_id'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>