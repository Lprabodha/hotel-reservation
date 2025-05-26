@extends('layouts.admin.app')

@section('content')
{{-- @dd($imageUrls) --}}
    @foreach($imageUrls as $imageUrl)
        <img src="{{ 'hotels/0ac017c1-bcd4-4581-9305-ae155aadd4cc.jpg' }}" alt="Hotel Image" class="img-fluid">
    @endforeach

@endsection