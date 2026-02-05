@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Search Listings</h2>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="keyword"
                   value="{{ request('keyword') }}"
                   class="form-control"
                   placeholder="Keyword">
        </div>

        <div class="col-md-2">
            <input type="text" name="city"
                   value="{{ request('city') }}"
                   class="form-control"
                   placeholder="City">
        </div>

        <div class="col-md-2">
            <input type="number" name="min_price"
                   value="{{ request('min_price') }}"
                   class="form-control"
                   placeholder="Min Price">
        </div>

        <div class="col-md-2">
            <input type="number" name="max_price"
                   value="{{ request('max_price') }}"
                   class="form-control"
                   placeholder="Max Price">
        </div>

        <div class="col-md-2">
            <select name="sort" class="form-select">

                <option value="newest"
                    {{ request('sort') == 'newest' ? 'selected' : '' }}>
                    Newest
                </option>

                <option value="price"
                    {{ request('sort') == 'price' ? 'selected' : '' }}>
                    Price (Low to High)
                </option>

                <option value="relevance"
                    {{ request('sort') == 'relevance' ? 'selected' : '' }}>
                    Relevance
                </option>

            </select>
        </div>

        <div class="col-md-1">
            <button class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <div class="row" id="listing-container"></div>

    <div id="loading" class="text-center my-4" style="display:none;">
        <div class="spinner-border text-primary"></div>
    </div>

</div>

<script>
let loading = false;
let nextCursor = null;

function loadListings() {

    if (loading) return;
    loading = true;

    const params = new URLSearchParams(window.location.search);

    if (nextCursor) {
        params.set('cursor', nextCursor);
    }

    fetch('/api/listings?' + params.toString())
        .then(res => res.json())
        .then(response => {

            const listings = response.data;
            nextCursor = response.next_cursor;

            const container = document.getElementById('listing-container');

            listings.forEach(listing => {
                container.insertAdjacentHTML('beforeend', `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5>${listing.title}</h5>
                                <p>${listing.description.substring(0,80)}...</p>
                                <p><strong>City:</strong> ${listing.city}</p>
                                <p><strong>Price:</strong> $${listing.price}</p>
                                <p><strong>Status:</strong> ${listing.status}</p>
                            </div>
                        </div>
                    </div>
                `);
            });

            loading = false;
        });
}

document.addEventListener('DOMContentLoaded', function () {
    loadListings();
});

window.addEventListener('scroll', function () {

    if (!nextCursor) return;

    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 150) {
        loadListings();
    }
});
</script>

@endsection
