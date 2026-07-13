<th scope="row">{{ $movie['title'] }}</th>
<td>
    @if(isset($movie['genres']))
        @foreach ($movie['genres'] as $genre)
            {{ $genre['name'] }}<br/>
        @endforeach
    @else
        <p></p>
    @endif
</td>
<td>{{ $movie['overview'] }}</td>
@if(!empty($movie['release_date']))
    <td class="wider-column">{{ \Carbon\Carbon::parse($movie['release_date'])->format('M d, Y') }}</td>
@else
    <td class="wider-column">N/A</td>
@endif
