@extends('layouts.main')
@section('title', 'Home')

@section('content')
<h1>Hello, {{ $user->name }}</h1>
@if($user->state > 1 && $user->state < 4)
    <ul class="w3-ul w3-border">
        <li class="w3-theme w3-xxlarge">目前賠率限額</li>
        <li class="w3-xlarge">單場最大賠率: {{ $user->rate()->bg }}</li>
        <li class="w3-xlarge">單場最小賠率: {{ $user->rate()->sg }}</li>
        <li class="w3-xlarge">單注最大賠率: {{ $user->rate()->bb }}</li>
        <li class="w3-xlarge">單注最小賠率: {{ $user->rate()->sb }}</li>
    </ul>
@endif

@if($user->state < 4)
    <h3>您可以:</h3>
    <div class="w3-btn-group">
        @if ($user->state != 0 && $user->state != 1)
        <a href="{{ url('setRate') }}" class="w3-btn w3-theme-d1 w3-ripple w3-large">設定賠率</a>
        @endif
        <a href="{{ url('lookBelow') }}" class="w3-btn w3-theme-d2 w3-ripple w3-large">查看下層</a>
        <a href="{{ url('addBelow') }}" class="w3-btn w3-theme-d3 w3-ripple w3-large">新增下層</a>
    </div>
@endif
@endsection