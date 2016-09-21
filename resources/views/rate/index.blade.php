@extends('layouts.main')
@section('title', 'Home')

@section('content')
<h1>Hello, {{ Auth::user()->name }}</h1>
<h3>您可以:</h3>
<div class="w3-btn-group">
    @if ($user->state != 0 && $user->state != 1)
    <a href="{{ url('setRate') }}" class="w3-btn w3-theme-d1 w3-ripple">設定賠率</a>
    @endif
    <a href="{{ url('lookBelow') }}" class="w3-btn w3-theme-d2 w3-ripple">查看下層</a>
    <a href="{{ url('addBelow') }}" class="w3-btn w3-theme-d3 w3-ripple">新增下層</a>
</div>
@endsection