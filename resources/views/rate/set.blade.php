@extends('layouts.main')
@section('title', '設定賠率')

@section('content')
@if (Auth::user()->id != $user->id)
    <h1>設定 {{ $user->name }} 的賠率限額</h1>
@endif

<form method="post" action="{{ url('setRate') }}" class="w3-padding">
    {{ csrf_field() }}
    @if (Auth::user()->id != $user->id)
        <input type="hidden" name="id" value="{{ $user->id }}">
    @endif

    <div class="w3-row-padding w3-margin">
        <div class="w3-col m6 w3-margin-bottom">
            <label class="w3-label w3-large">單場最大賠率</label>
            <input class="w3-input w3-large" type="number" name="bg" value="{{ old('bg') ? old('bg') : $user->rate()->bg }}" min="10" max="{{ $user->up()->rate()->bg or 999999}}" required>
            @if ($errors->has('bg'))
                <ul class="w3-text-red w3-ul">
                    @foreach ($errors->get('bg') as $error)
                        <li><strong>{{ $error }}</li></strong>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="w3-col m6 w3-margin-bottom">
            <label class="w3-label w3-large">單場最小賠率</label>
            <input class="w3-input w3-large" type="number" name="sg" value="{{ old('sg') ? old('sg') : $user->rate()->sg }}" min="10" max="{{ $user->up()->rate()->bg or 999999}}" required>
            @if ($errors->has('sg'))
                <ul class="w3-text-red w3-ul">
                    @foreach ($errors->get('sg') as $error)
                        <li><strong>{{ $error }}</li></strong>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="w3-col m6 w3-margin-bottom">
            <label class="w3-label w3-large">單注最大賠率</label>
            <input class="w3-input w3-large" type="number" name="bb" value="{{ old('bb') ? old('bb') : $user->rate()->bb }}" min="10" max="{{ $user->up()->rate()->bb or 999999}}" required>
            @if ($errors->has('bb'))
                <ul class="w3-text-red w3-ul">
                    @foreach ($errors->get('bb') as $error)
                        <li><strong>{{ $error }}</li></strong>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="w3-col m6 w3-margin-bottom">
            <label class="w3-label w3-large">單注最小賠率</label>
            <input class="w3-input w3-large" type="number" name="sb" value="{{ old('sb') ? old('sb') : $user->rate()->sb }}" min="10" max="{{ $user->up()->rate()->bb or 999999 }}" required>
            @if ($errors->has('sb'))
                <ul class="w3-text-red w3-ul">
                    @foreach ($errors->get('sb') as $error)
                        <li><strong>{{ $error }}</li></strong>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="w3-input-group w3-center">
        <button name="Save" class="w3-btn w3-round w3-theme-d1 w3-ripple">儲存</button>
        @if($user->id == Auth::user()->id)
        <button name="Syn" onclick="event.preventDefault(); document.getElementById('synchronize').submit()" class="w3-btn w3-round w3-theme-d3 w3-ripple">同步</button>
        @endif
        <a href="{{ $response or url('/') }}" class="w3-btn w3-round w3-theme-d5 w3-ripple">回上層</a>
    </div>
</form>
@if($user->id == Auth::user()->id)
<form id="synchronize" action="{{ url('synchronize') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
@endif
@endsection