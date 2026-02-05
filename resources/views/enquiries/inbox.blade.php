@extends('layouts.app')

@section('content')

<h3>Inbox</h3>

@foreach($enquiries as $enquiry)

<div class="card mb-3">
    <div class="card-body">

        <h5>{{ $enquiry->listing->title }}</h5>

        <p>
            From: {{ $enquiry->customer->name }}
        </p>

        <a href="{{ route('enquiries.show',$enquiry->id) }}"
           class="btn btn-sm btn-primary">
            View Conversation
        </a>

    </div>
</div>

@endforeach

@endsection
