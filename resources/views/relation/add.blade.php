@extends('layouts.main')
@section('title', '新增下層成員')

@section('content')

<form method="post" action="{{ url('addBelow') }}">
    {{ csrf_field() }}

    <div class="w3-input-group">
        <label class="w3-label">名稱</label>
        <input class="w3-input" type="text" name="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
            <ul class="w3-text-red w3-ul">
                @foreach ($errors->get('name') as $error)
                    <li><strong>{{ $error }}</li></strong>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="w3-input-group">
        <label class="w3-label">Email</label>
        <input class="w3-input" type="eamil" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <ul class="w3-text-red w3-ul">
                @foreach ($errors->get('email') as $error)
                    <li><strong>{{ $error }}</li></strong>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="w3-input-group">
        <label class="w3-label">密碼</label>
        <input class="w3-input" type="password" name="password" required>
        @if ($errors->has('password'))
            <ul class="w3-text-red w3-ul">
                @foreach ($errors->get('password') as $error)
                    <li><strong>{{ $error }}</li></strong>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="w3-input-group">
        <label class="w3-label">確認密碼</label>
        <input type="password" class="w3-input" name="password_confirmation" required>
    </div>

    <div class="w3-input-group">
        <label class="w3-label">角色</label><br>
        @for ($i = $master; $i < count($roles); $i++)
            @if ($master == 0 || $master != $i)
                <input class="w3-radio" type="radio" name="state" value="{{ $i }}" checked>
                <label class="w3-validate">{{ $roles[$i] }}</label>
            @endif
        @endfor
        @if ($errors->has('state'))
            <ul class="w3-text-red w3-ul">
                @foreach ($errors->get('state') as $error)
                    <li><strong>{{ $error }}</li></strong>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="w3-input-group">
        <label class="w3-label">上層成員</label>
        <select class="w3-select" name="up">
            <option value="" disabled selected>選擇上層成員</option>
            @if($master == 0)
            <option value="">【無】</option>
            @endif
            @foreach ($ups as $up)
                <option value="{{ $up->id }}">【{{ $roles[$up->state]  }}】 {{ $up->name }} - {{ $up->email }}</option>
            @endforeach
        </select>
        @if ($errors->has('up'))
            <ul class="w3-text-red w3-ul">
                @foreach ($errors->get('up') as $error)
                    <li><strong>{{ $error }}</li></strong>
                @endforeach
            </ul>
        @endif
    </div>

    <input type="submit" value="新增下層" class="w3-btn">
    <a href="{{ url('/') }}" class="w3-btn w3-ripple">回首頁</a>
</form>
@endsection