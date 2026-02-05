@foreach($listings as $listing)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">

                <h5>{{ $listing->title }}</h5>

                <p class="text-muted">
                    {{ \Illuminate\Support\Str::limit($listing->description, 80) }}
                </p>

                <p>
                    <span class="badge bg-primary">
                        {{ optional($listing->category)->name }}
                    </span>
                </p>

                <p>
                    <strong>City:</strong> {{ $listing->city }}
                </p>

                <p>
                    <strong>Price:</strong>
                    ${{ number_format($listing->price,2) }}
                    / {{ ucfirst($listing->pricing_type) }}
                </p>
                <p>
                    <strong>Status:</strong>
                    {{ ucfirst($listing->status) }}
                </p>
                

            </div>
        </div>
    </div>
@endforeach

@if($listings->hasMorePages())
    <div id="next-cursor"
         data-cursor="{{ $listings->nextCursor()->encode() }}">
    </div>
@endif
