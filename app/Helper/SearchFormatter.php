<?php

namespace App\Helper;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Request;

class SearchFormatter
{
    public static function getPaginatedSearchResults(Request $request, string $model, Builder $query = null): LengthAwarePaginator
    {
        $searchQuery = self::getSearchQueries($request, $model, $query);

        return $searchQuery->paginate($request->input('per_page'));
    }

    public static function getSearchResults(Request $request, string $model, Builder $query = null): Collection
    {
        return self::getSearchQueries($request, $model, $query)->get();
    }

    public static function getSearchQueries(Request $request, string $model, Builder $query = null, $sort = null): Builder
    {
        $search = $request->get('search');

        $exactSearch = $request->get('exact_search') ?? [];
        $whereHas = $request->get('where_has') ?? [];

        $startDateSearch = $request->get('start_date');
        $endDateSearch = $request->get('end_date');
        $dateSearch = $request->get('date');

        if (! $sort) {
            $sort = $request->get('sort') ?? [
                    'id' => 'DESC',
                ];
        }

        if (! isset($query)) {
            $query = $model::query();
        }

        foreach ($sort as $parameter => $direction) {
            $query = $model::orderBy($parameter, $direction);
        }

        if ($search) {
            $query = self::getSearchQuery($request, $model, $query);
        }

        if ($exactSearch) {
            $query = self::getExactSearchQuery($request, $model, $query);
        }

        if ($whereHas) {
            $query = self::getWhereHasQuery($request, $model, $query);
        }

        if ($startDateSearch or $endDateSearch or $dateSearch) {
            $query = self::getDateSearchQuery($request, $model, $query);
        }

        if ($query) {
            return $query;
        }

        return $model::query();
    }

    public static function requestHasSearchParameters(Request $request): bool
    {
        $search = $request->get('search');

        $exactSearch = $request->get('exact_search');

        $startDateSearch = $request->get('start_date');
        $endDateSearch = $request->get('end_date');
        $dateSearch = $request->get('date');

        if ($search or $exactSearch or $startDateSearch or $endDateSearch or $dateSearch) {
            return true;
        }

        return false;
    }

    private static function getSearchQuery(Request $request, string $model, Builder $existinQuery = null): Builder
    {
        $search = $request->get('search');

        if ($search) {
            $searchTerm = '';
            $attributes = [];
            foreach ($search as $attribute => $term) {
                if (self::isEmpty($term) or $term == 'null') {
                    continue;
                }

                $attributes[] = $attribute;
                $searchTerm = $term;
            }

            return $model::searchModel($attributes, $searchTerm, $existinQuery);
        }

        return $model::query();
    }

    public static function getExactSearchQuery(Request $request, string $model, Builder $existinQuery = null): Builder
    {
        $search = $request->get('exact_search');

        if ($search) {
            $searchTerms = [];
            $attributes = [];
            foreach ($search as $attribute => $term) {
                if (self::isEmpty($term)) {
                    continue;
                }

                if ($term == 'null') {
                    $term = null;
                }

                $attributes[] = $attribute;

                if (is_array($term)) {
                    $searchTerms[] = $term;
                } else {
                    $searchTerms[] = [
                        $term,
                    ];
                }
            }

            return $model::exactSearch($attributes, $searchTerms, $existinQuery);
        }

        return $model::query();
    }

    public static function getDateSearchQuery(Request $request, string $model, Builder $existinQuery = null): Builder
    {
        $startDateSearch = $request->get('start_date');
        $endDateSearch = $request->get('end_date');
        $dateSearch = $request->get('date');

        $startDate = '';
        $endDate = '';
        $searchAttribute = '';

        if ($dateSearch) {
            foreach ($dateSearch as $attribute => $term) {
                if (self::isEmpty($term)) {
                    continue;
                }

                $searchAttribute = $attribute;
                $startDate = $term;
                $endDate = $term;
            }
        }

        if ($startDateSearch) {
            foreach ($startDateSearch as $attribute => $term) {
                if (self::isEmpty($term)) {
                    continue;
                }

                $searchAttribute = $attribute;
                $startDate = $term;
            }
        }

        if ($endDateSearch) {
            foreach ($endDateSearch as $attribute => $term) {
                if (self::isEmpty($term)) {
                    continue;
                }

                $searchAttribute = $attribute;
                $endDate = $term;
            }
        }

        return $model::dateFilter($searchAttribute, $startDate, $endDate, $existinQuery);
    }

    public static function isEmpty(?string $value): bool
    {
        return empty($value) && $value !== '0' && $value !== 0;
    }

    public static function getWhereHasQuery(Request $request, string $model, Builder $existingQuery = null): Builder
    {
        $search = $request->get('where_has');
        $query = $model::query();

        if ($search) {
            if ($existingQuery) {
                $query = $existingQuery;
            }
        }

        return $query;
    }
}
