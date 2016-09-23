@extends('layouts.main')
@section('title', '查看下層成員')

@section('content')

<style>
.info {
    display: none;
}
</style>
<a href="{{ url('/') }}" class="w3-btn-floating w3-teal"><i class="fa fa-home"></i></a>
@if($master->id != Auth::user()->id)
<a href="{{ url('lookBelow') }}" class="w3-btn-floating w3-green"><i class="fa fa-mail-reply"></i></a>
<h1 class="w3-xxlarge "><a href="{{ $master->up_id ? url('seekBelow/'. $master->up_id->up) : url('lookBelow') }}" style="text-decoration: none;" class="w3-hover-text-theme">{{ $master->name }}</a> 以下層級</h1>
@endif

<ul class="w3-navbar w3-theme">
    @for ($i = $master->state; $i < count($roles); $i++)
        @if ($master->state == 0 || $master->state != $i)
            <li><a href="#" class="tablink w3-btn w3-theme w3-xlarge" onclick="lookUsers(event, '{{ $roles[$i] }}');">{{ $roles[$i] }}</a></li>
        @endif
    @endfor
</ul>

@for ($i = $master->state; $i < count($roles); $i++)
    @if ($master->state == 0 || $master->state != $i)
        <div id="{{ $roles[$i] }}" class="info w3-animate-left">
          @if($i < 2)
            @include('relation.info')
          @else
            @include('relation.table')
          @endif
        </div>
    @endif
@endfor

<script>
  document.getElementsByClassName("info")[0].style.display = "block";
  document.getElementsByClassName("tablink")[0].className = document.getElementsByClassName("tablink")[0].className.replace("w3-theme", "w3-blue");

function lookUsers(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("info");
  for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace("w3-blue", "w3-theme");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className = evt.currentTarget.className.replace("w3-theme", "w3-blue");
}
</script>

@endsection