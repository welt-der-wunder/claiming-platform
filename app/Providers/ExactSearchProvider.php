<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ExactSearchProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot(): void
    {
        Builder::macro('exactSearch', function ($attributes, array $searchTerms, Builder $query = null) {
            if (! $query) {
                $query = $this;
            }

            $query->where(function (Builder $query) use ($attributes, $searchTerms) {
                foreach (array_wrap($attributes) as $key => $attribute) {
                    $searchTermsInput = [];
                    if (is_array($searchTerms[$key])) {
                        foreach ($searchTerms[$key] as $searchItem) {
                            $searchTermsInput[] = $searchItem === null ? null : strtoupper($searchItem);
                        }
                    } else {
                        $searchTermsInput[] = $searchTerms[$key] === null ? null : strtoupper($searchTerms[$key]);
                    }

                    $query->when(str_contains($attribute, '.'), function (Builder $query) use ($attribute, $searchTermsInput, $key) {
                        [
                            $relationName,
                            $relationAttribute
                        ] = explode('.', $attribute);
                        $query->whereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTermsInput, $key) {
                            $query->whereIn(DB::raw('upper('.$relationAttribute.')'), $searchTermsInput);

                            if (in_array(null, $searchTermsInput)) {
                                $query->orWhereNull(DB::raw('upper('.$relationAttribute.')'));
                            }

                            if (in_array('NOT_NULL', $searchTermsInput)) {
                                $query->orWhereNotNull(DB::raw('upper('.$relationAttribute.')'));
                            }
                        });
                    }, function (Builder $query) use ($attribute, $searchTermsInput, $key) {
                        $query->whereIn(DB::raw('upper('.$attribute.')'), $searchTermsInput);

                        if (in_array(null, $searchTermsInput)) {
                            $query->orWhereNull(DB::raw('upper('.$attribute.')'));
                        }

                        if (in_array('NOT_NULL', $searchTermsInput)) {
                            $query->orWhereNotNull(DB::raw('upper('.$attribute.')'));
                        }
                    });
                }
            });

            return $query;
        });
    }
}
