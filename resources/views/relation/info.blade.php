@if(empty($belows[$i]))
  <h3>目前無下層會員</h3>
@else
  <table class="w3-card-4 w3-table w3-striped  w3-hoverable">
    <tr class="w3-large w3-blue">
      <th>名稱</th>
    </tr>
    @foreach ($belows[$i] as $below)
    <tr>
      <td>
        @if($below->state && $below->state < 4)
          <a href="{{ url('seekBelow/' . $below->id) }}">{{ $below->name }}</a>
        @else
          {{ $below->name }}
        @endif
      </td>
    </tr>
    @endforeach
</table>
@endif