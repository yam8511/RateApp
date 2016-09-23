@if(empty($belows[$i]))
  <h3>目前無下層會員</h3>
@else
  <table class="w3-card-4 w3-table w3-striped  w3-hoverable">
    <tr class="w3-large w3-blue">
      <th>名稱</th>
      <th>單場最大賠率</th>
      <th>單場最小賠率</th>
      <th>單注最大賠率</th>
      <th>單注最小賠率</th>
      <th>設定</th>
    </tr>
    @foreach ($belows[$i] as $below)
    <tr>
      <td>
        @if($below->state && $below->state < 4)
          <a href="{{ url('seekBelow/' . $below->id) }}">{{ $below->name }}</a>
        @else
          <a href="{{ url('seekBelow/' . $below->up_id->up) }}">{{ $below->name }}</a>
        @endif
      </td>
      <td>{{ $below->rate()->bg or ''}}</td>
      <td>{{ $below->rate()->sg or ''}}</td>
      <td>{{ $below->rate()->bb or ''}}</td>
      <td>{{ $below->rate()->sb or ''}}</td>
      <td><a href="{{ url('setOtherRate/' . $below->id) }}" class="w3-btn w3-round w3-hover-text-theme">設定</a></td>
    </tr>
    @endforeach
</table>
@endif