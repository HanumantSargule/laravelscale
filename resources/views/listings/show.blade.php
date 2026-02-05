@extends('layouts.app')

@section('content')

<h2>{{ $listing->title }}</h2>
<p>{{ $listing->description }}</p>
<p>City: {{ $listing->city }}</p>
<p>Price: ${{ $listing->price }}</p>
<p>Provider: {{ $listing->provider->name }}</p>

@auth
@if(auth()->user()->isCustomer())
<form method="POST" action="{{ route('enquiries.store',$listing->id) }}">
    @csrf
    <textarea name="message" required></textarea>
    <button>Send Enquiry</button>
</form>
@endif
@endauth

@endsection
