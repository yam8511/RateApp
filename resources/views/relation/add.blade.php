@extends('layouts.main')
@section('title', '新增下層會員')

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="post" action="{{ url('addBelow') }}">
    {{ csrf_field() }}

    <div class="w3-input-group">
        <label class="w3-label">名稱</label>
        <input class="w3-input" type="text" name="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
            <span class="w3-text-red">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="w3-input-group">
        <label class="w3-label">Email</label>
        <input class="w3-input" type="eamil" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <span class="w3-text-red">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="w3-input-group">
        <label class="w3-label">密碼</label>
        <input class="w3-input" type="password" name="password" required>
        @if ($errors->has('password'))
            <span class="w3-text-red">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
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
            <span class="w3-text-red">
                <strong>{{ $errors->first('state') }}</strong>
            </span>
        @endif
    </div>

    <div class="w3-input-group">
        <label class="w3-label">上層會員</label>
        <select class="w3-select" name="up">
            <option value="0" disabled selected>選擇上層會員</option>
            @foreach ($ups as $up)
                <option value="{{ $up->id }}">【{{ $roles[$up->state]  }}】 {{ $up->name }} - {{ $up->email }}</option>
            @endforeach
        </select>
        @if ($errors->has('up'))
            <span class="w3-text-red">
                <strong>{{ $errors->first('up') }}</strong>
            </span>
        @endif
    </div>

    <input type="submit" value="新增下層" class="w3-btn">
    <a href="{{ url('/') }}" class="w3-btn w3-ripple">回首頁</a>
</form>
@endsection