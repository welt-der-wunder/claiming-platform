<?php

namespace App\Helper;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use MeiliSearch\Endpoints\Indexes;

class SearchQueryFormatter
{
    public static function getIdResultFromQuery(string $model, string $searchIndex, string $filters = '', string $query = ''): array
    {
        $queryResult = self::runQuery($model, $searchIndex, $filters, $query);

        return $queryResult->get()
            ->pluck('id')
            ->toArray();
    }

    public static function getPaginatedResultFromQuery(Request $request, string $model, string $searchIndex, string $filters = ''): LengthAwarePaginator
    {
        $page = $request->query('page') ?? 1;
        $perPage = $request->query('per_page') ?? 10;
        $query = $request->query('query') ?? '';

        if (is_array($query)) {
            $orderBy = implode(' ', $query);
        }

        $orderBy = $request->query('order_by') ?? 'created_at';

        if (is_array($orderBy)) {
            $orderBy = implode(',', $orderBy);
        }

        $order = $request->query('order');

        if (is_string($order)) {
            $orderDirection = strtolower($order);
        } else {
            $orderDirection = 'desc';
        }

        $queryResult = self::runQuery($model, $searchIndex, $filters, $query, $orderBy.':'.$orderDirection);

        return $queryResult->paginate($perPage, 'page', $page);
    }

    public static function whereNotInFilter(string $field, array $notInArray = [], bool $iQuerysStart = false): string
    {
        $arrayCount = count($notInArray);

        if ($arrayCount === 0) {
            return '';
        }

        $filter = '(';

        if (! $iQuerysStart) {
            $filter = ' AND '.$filter;
        }

        foreach ($notInArray as $key => $notId) {
            $filter = $filter.$field.' != '.$notId;
            if ($key != ($arrayCount - 1)) {
                $filter = $filter.' AND ';
            }
        }
        $filter = $filter.')';

        return $filter;
    }

    public static function whereInFilter(string $field, array $inArray = [], bool $iQuerysStart = false): string
    {
        $arrayCount = count($inArray);

        if ($arrayCount === 0) {
            return '';
        }

        $filter = '(';

        if (! $iQuerysStart) {
            $filter = ' AND '.$filter;
        }

        foreach ($inArray as $key => $id) {
            $filter = $filter.$field.' = '.$id;
            if ($key != ($arrayCount - 1)) {
                $filter = $filter.' OR ';
            }
        }
        $filter = $filter.')';

        return $filter;
    }

    /**
     * @return mixed
     */
    private static function runQuery(string $model, string $searchIndex, string $filters = '', string $query = '', string $sort = 'created_at:desc')
    {
        return $model::search($query, function (Indexes $index, $query, $options) use ($filters, $sort) {
            if (! empty($filters)) {
                $options['filter'] = $filters;
            }

            $options['sort'] = [
                $sort,
            ];

            return $index->rawSearch($query, $options);
        })->within($searchIndex);
    }
}
