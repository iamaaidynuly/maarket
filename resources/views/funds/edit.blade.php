@extends('adminlte::layout.main', ['title' => 'Редактировать акцию'])

@section('content')
    @component('adminlte::page', ['title' => 'Редактировать акцию'])
        @component('adminlte::box')
            <a href="{{ route('funds.index') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
            <br />
            <br />

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('funds.update', $funds->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name">Название:</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{$funds->name}}">
                </div>
                <div class="form-group">
                    <label for="min_count">Мин.количество:</label>
                    <input id="min_count" name="min_count" type="text" class="form-control" value="{{$funds->min_count}}">
                </div>
                <div class="form-group">
                    <label for="bonus">Бонус:</label>
                    <input id="bonus" name="bonus" type="text" class="form-control" value="{{$funds->bonus}}">
                </div>
                <div class="form-group">
                    <label for="type">Выберите тип:</label>
                    <select name="type" id="type" class="form-control">
                        <option value="product" @if($funds->type == 'product') selected @endif>Продукт</option>
                        <option value="discount"  @if($funds->type == 'discount') selected @endif>Бонус</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm">Сохранить</button>
                </div>

            </form>
        @endcomponent
    @endcomponent

@endsection
