@extends('layouts.app')

@section('title', 'Index')

@section('content')

<form action="{{ route('order.store') }}" method="POST">
  @csrf
  <input class="btn btn-custom" type="submit" value="Objednať">
  <div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>-</th>
        <th><a href="@if(app('request')->input('sort_by') === 'name') {{ route('index', ['sort_by_desc' => 'name']) }} @else {{ route('index', ['sort_by' => 'name']) }} @endif">Meno @if(app('request')->input('sort_by') === 'name')<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>@elseif(app('request')->input('sort_by_desc') === 'name') <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> @endif </a></th>
        <th>Popis</th>
        <th><a href="@if(app('request')->input('sort_by') === 'onstock') {{ route('index', ['sort_by_desc' => 'onstock']) }} @else {{ route('index', ['sort_by' => 'onstock']) }} @endif">Na sklade @if(app('request')->input('sort_by') === 'onstock')<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> @elseif(app('request')->input('sort_by_desc') === 'onstock') <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>@endif</a></th>
        <th>Obrázok</th>
        <th><a href="@if(app('request')->input('sort_by') === 'weight') {{ route('index', ['sort_by_desc' => 'weight']) }} @else {{ route('index', ['sort_by' => 'weight']) }} @endif">Váha @if(app('request')->input('sort_by') === 'weight')<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> @elseif(app('request')->input('sort_by_desc') === 'weight') <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> @endif</a></th>
        <th>Ks do objednávky</th>
      </tr>
    </thead>
    <tbody>
  @foreach ($items as $item)
    <tr>
      <td> {{ $loop->index }} <input value="{{ $item['id']; }}" type="hidden" name="order_data[{{ $loop->index }}][product_id]"> </td>
      <td>{{ $item['name']; }}</td>
      <td> {!! $item['shortdescription'] !!} </td>
      <td> @if ( $item['onstock'] == 'true') {{ 'Áno' }} @else {{ 'Nie' }} @endif </td>
      <td> <img class="img-thumbnail" src="{{ $item['picturemain']; }}" alt=""> </td>
      <td> {{ $item['weight']; }} </td>
      <td><input type="number" name="order_data[{{ $loop->index }}][quantity]" placeholder="0" min="1" max="10"></td>
    </tr>
  @endforeach
  </tbody>
</table>
</div>
</form>
@endsection