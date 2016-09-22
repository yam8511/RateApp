@extends('layouts.main')
@section('title', '設定賠率')

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
<form method="post" action="{{ url('setRate') }}" class="w3-padding">
    {{ csrf_field() }}

    <div class="w3-row-padding w3-margin">
        <div class="w3-col m6">
            <label class="w3-label">單場最大賠率</label>
            <input class="w3-input" type="number" name="bg" value="{{ $user->bg or 0 }}" required>
            @if ($errors->has('bg'))
                <span class="w3-text-red">
                    <strong>{{ $errors->first('bg') }}</strong>
                </span>
            @endif
        </div>

        <div class="w3-col m6">
            <label class="w3-label">單場最小賠率</label>
            <input class="w3-input" type="number" name="sg" value="{{ $user->sg or 0 }}" required>
            @if ($errors->has('sg'))
                <span class="w3-text-red">
                    <strong>{{ $errors->first('sg') }}</strong>
                </span>
            @endif
        </div>

        <div class="w3-col m6">
            <label class="w3-label">單注最大賠率</label>
            <input class="w3-input" type="number" name="bb" value="{{ $user->bb or 0 }}" required>
            @if ($errors->has('bb'))
                <span class="w3-text-red">
                    <strong>{{ $errors->first('bb') }}</strong>
                </span>
            @endif
        </div>

        <div class="w3-col m6">
            <label class="w3-label">單注最小賠率</label>
            <input class="w3-input" type="number" name="sb" value="{{ $user->sb or 0 }}" required>
            @if ($errors->has('sb'))
                <span class="w3-text-red">
                    <strong>{{ $errors->first('sb') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="w3-input-group w3-center">
        <button onclick="" class="w3-btn w3-round w3-theme-d1 w3-ripple">儲存</button>
        <button onclick="" class="w3-btn w3-round w3-theme-d3 w3-ripple">同步</button>
        <a href="{{ url('/') }}" class="w3-btn w3-round w3-theme-d5 w3-ripple">回首頁</a>
    </div>
</form>
@endsection