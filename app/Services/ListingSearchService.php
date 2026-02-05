<?php

namespace App\Services;

use App\Models\Listing;

class ListingSearchService
{
    public function search(array $filters)
    {
        $sort = $filters['sort'] ?? 'newest';

        $query = Listing::query()
            ->where('status', Listing::STATUS_APPROVED);

        if (!empty(trim($filters['keyword'] ?? ''))) {
            $query->whereFullText(['title','description'], $filters['keyword']);
            if ($sort === 'relevance') {
                $query->selectRaw(
                    "MATCH(title, description) AGAINST (? IN NATURAL LANGUAGE MODE) as relevance_score",
                    [$keyword]
                )->orderByDesc('relevance_score')
                ->orderBy('created_at','desc');
            }
        }

        if (!empty($filters['category'] ?? null)) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['city'] ?? null)) {
            $query->where('city', $filters['city']);
        }

        if (
            isset($filters['min_price']) &&
            isset($filters['max_price']) &&
            $filters['min_price'] !== '' &&
            $filters['max_price'] !== ''
        ) {
            $query->whereBetween('price', [
                (float)$filters['min_price'],
                (float)$filters['max_price']
            ]);
        }

        if ($sort === 'price') {
            $query->orderBy('price','asc');
        }

        if ($sort === 'newest') {
            $query->orderBy('created_at','desc');
        }

        if ($sort === 'relevance' && empty($filters['keyword'])) {
            $query->orderBy('created_at','desc');
        }

        return $query->cursorPaginate(50);
    }

}
