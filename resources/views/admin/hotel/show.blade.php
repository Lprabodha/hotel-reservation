@extends('layouts.admin.app')

@section('content')
    @foreach($imageUrls as $imageUrl)
        <img src="{{ $imageUrl }}" alt="Hotel Image" class="img-fluid">
    @endforeach
@endsection