<?php

namespace App\Http\Controllers\Api;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Services\ListingSearchService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreListingRequest;
use App\Actions\Listing\CreateListingAction;

class ListingController extends Controller
{
    public function index(Request $request, ListingSearchService $service)
    {
        $listings = $service->search($request->all());

        return response()->json($listings);
    }

    public function show(Listing $listing)
    {
        abort_if($listing->status !== 'approved', 404);

        $listing->load('provider','category');

        return response()->json($listing);
    }

    public function store(StoreListingRequest $request, CreateListingAction $action)
    {
        $this->authorize('create', Listing::class);

        $listing = $action->execute(
            $request->validated(),
            auth()->user()
        );

        return response()->json([
            'message' => 'Listing submitted for approval',
            'data' => $listing
        ], 201);
    }

    public function update(StoreListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $listing->update($request->validated());

        return response()->json([
            'message' => 'Listing updated',
            'data' => $listing
        ]);
    }

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return response()->json([
            'message' => 'Listing deleted'
        ]);
    }
}
