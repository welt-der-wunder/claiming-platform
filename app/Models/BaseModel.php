<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    public static function getTableName(): string
    {
        return with(new static())->getTable();
    }

    public static function attributeExists(string $attributeName): bool
    {
        return Schema::hasColumn(self::getTableName(), $attributeName);
    }

    public static function getAllAttributes(): array
    {
        $self = new static();
        if (method_exists($self, 'getLimitedSearchableAttributes')) {
            return $self::getLimitedSearchableAttributes();
        }

        $attributes = Schema::getColumnListing(self::getTableName());
        $response = [];

        foreach ($attributes as $attribute) {
            $response[] = $attribute;

            if ($attribute === 'id') {
                $response[] = self::getTableName().'.'.$attribute;
            }
        }

        $response = array_merge($self::getSearchableRelationships(), $response);
        $response = array_merge($self::getAdditionalSearchableAttributes(), $response);

        return $response;
    }

    public static function makeAllAttributesSearchable($chunk = null)
    {
        $self = new static();

        $softDelete = static::usesSoftDelete() && config('scout.soft_delete', false);

        $self->newQuery()
        ->when(true, function ($query) use ($self) {
            $self->makeAllSearchableUsing($query);
        })
        ->when($softDelete, function ($query) {
            $query->withTrashed();
        })
        ->orderBy(self::getTableName().'.'.$self->getKeyName())
        ->searchable($chunk);
    }

    public static function getSearchableRelationships()
    {
        return [];
    }

    public static function getAdditionalSearchableAttributes()
    {
        return [];
    }
}
