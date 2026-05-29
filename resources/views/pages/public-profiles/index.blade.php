<?php ?>
<p>Hello</p>

@foreach($profiles as $profile)
    <p>{{$profile->given_name}} {{$profile->family_name}}</p>
@endforeach
