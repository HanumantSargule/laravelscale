<?php

namespace App\Http\Controllers\Api;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ListingSearchService;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Actions\Listing\CreateListingAction;

class ListingController extends Controller
{
    /**
     * GET /api/listings
     * Public search endpoint
     */
    public function index(Request $request, ListingSearchService $service)
    {
        $listings = $service->search($request->all());

        return response()->json([
            'data' => $listings->items(),
            'next_cursor' => optional($listings->nextCursor())->encode(),
        ]);
    }

    /**
     * GET /api/listings/{listing}
     */
    public function show(Listing $listing)
    {
        abort_if($listing->status !== Listing::STATUS_APPROVED, 404);

        $listing->load(['provider:id,name', 'category:id,name']);

        return response()->json([
            'success' => true,
            'data' => $listing
        ]);
    }

    /**
     * POST /api/listings
     */
    public function store(StoreListingRequest $request, CreateListingAction $action)
    {
        $this->authorize('create', Listing::class);

        $listing = $action->execute(
            $request->validated(),
            auth()->user()
        );

        return response()->json([
            'success' => true,
            'message' => 'Listing submitted for approval',
            'data' => $listing
        ], 201);
    }

    /**
     * PUT /api/listings/{listing}
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $listing->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Listing updated successfully',
            'data' => $listing
        ]);
    }

    /**
     * DELETE /api/listings/{listing}
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return response()->json([
            'success' => true,
            'message' => 'Listing deleted successfully'
        ]);
    }
}
