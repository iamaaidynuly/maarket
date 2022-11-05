<div class="form-group col-md-6 {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Имя' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($order->name) ? $order->name : ''}}">
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('l_name') ? 'has-error' : ''}}">
    <label for="l_name" class="control-label">{{ 'Фамилия' }}</label>
    <input class="form-control" name="l_name" type="text" id="l_name"
           value="{{ isset($order->l_name) ? $order->l_name : ''}}">
    {!! $errors->first('l_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-12 {{ $errors->has('phone') ? 'has-error' : ''}}">
    <label for="phone" class="control-label">{{ 'Телефон' }}</label>
    <input class="form-control" name="phone" type="text" id="phone"
           value="{{ isset($order->phone) ? $order->phone : ''}}">
    {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-12 {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'E-mail' }}</label>
    <input class="form-control" name="email" type="text" id="email"
           value="{{ isset($order->email) ? $order->email : ''}}">
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group col-md-6 {{ $errors->has('region') ? 'has-error' : ''}}">
    <label for="region" class="control-label">{{ 'Область' }}</label>
    <input class="form-control" name="region" type="text" id="region"
           value="{{ isset($order_adress->region) ? $order_adress->region : ''}}">
    {!! $errors->first('region', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('city') ? 'has-error' : ''}}">
    <label for="city" class="control-label">{{ 'Город' }}</label>
    <input class="form-control" name="city" type="text" id="city"
           value="{{ isset($order_adress->city) ? $order_adress->city : ''}}">
    {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('street') ? 'has-error' : ''}}">
    <label for="street" class="control-label">{{ 'Улица' }}</label>
    <input class="form-control" name="street" type="text" id="street"
           value="{{ isset($order_adress->street) ? $order_adress->street : ''}}">
    {!! $errors->first('street', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group col-md-6 {{ $errors->has('house') ? 'has-error' : ''}}">
    <label for="house" class="control-label">{{ 'Дом' }}</label>
    <input class="form-control" name="house" type="text" id="house"
           value="{{ isset($order_adress->house) ? $order_adress->house : ''}}">
    {!! $errors->first('house', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group col-md-12 {{ $errors->has('comment') ? 'has-error' : ''}}">
    <label for="comment" class="control-label">{{ 'Комментарий' }}</label>
    <textarea class="form-control" rows="5" name="comment" type="textarea"
              id="comment">{{ isset($order->comment) ? $order->comment : ''}}</textarea>
    {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}
</div>
{{-- <div class="form-group col-md-12 {{ $errors->has('product_id') ? 'has-error' : ''}}">
    <label for="product_id" class="control-label">{{ 'Товар' }}</label>
    <select name="product_id" id="product_id" class="form-control js-example-basic-single" required >
        <option value="">Выберите товар</option>
        @foreach($product as $item)
            <option value="{{$item->id}}" @if(isset($order->product_id) && $item->id == $order->product_id) selected @endif> --- {{ $item->getTitle->ru }}</option>
        @endforeach
    </select>

    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div> --}}
<div class="form-group col-md-12 {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Статус заказа' }}</label>
    <select name="status" id="status" class="form-control js-example-basic-single" required>
        <option value="">Выберите статус заказа</option>
        @foreach($status as $item)
            <option value="{{$item->id}}" @if(isset($order->status) && $item->id == $order->status) selected @endif>
                --- {{ $item->getName->ru }}</option>
        @endforeach
    </select>

    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div>


{{-- <div class="form-group col-md-12 {{ $errors->has('pay_status') ? 'has-error' : ''}}">
    <label for="pay_status" class="control-label">{{ 'Статус оплаты' }}</label>
    <select name="pay_status" id="pay_status" class="form-control js-example-basic-single" required >
        <option value="0" @if(isset($order->getStatus->status) && $order->getStatus->status==0) selected @endif>Не оплачено</option>
        <option value="1" @if(isset($order->getStatus->status) && $order->getStatus->status==1) selected @endif>Оплачено</option>
    </select>

    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
</div> --}}

<div class="form-group col-md-12 {{ $errors->has('pay_status') ? 'has-error' : ''}}">
    <label for="pay_status" class="control-label">{{ 'Статус оплаты' }}</label>
    <select name="pay_status" id="pay_status" class="form-control js-example-basic-single" required>
        <option value="0" @if(isset($order->pay_status) && $order->pay_status==0) selected @endif>Не оплачено</option>
        <option value="1" @if(isset($order->pay_status) && $order->pay_status==1) selected @endif>Оплачено</option>
    </select>

    {!! $errors->first('pay_status', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group col-md-12 {{ $errors->has('count') ? 'has-error' : ''}}">
    <label for="count" class="control-label">{{ 'Количество' }}</label>
    <input class="form-control" name="count" type="number" id="count"
           value="{{ isset($order->count) ? $order->count : ''}}">
    {!! $errors->first('count', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Сохранить' }}">
</div>
