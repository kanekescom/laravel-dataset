<?php

namespace Kanekescom\Dataset;

trait SoftDeletes
{
    /**
     * Get only trashed of the items in the collection.
     *
     * @return array
     */
    public function onlyTrashed()
    {
        return (new static)->collection->filter(function ($item) {
            return filled($item[self::DELETED_AT] ?? null);
        });
    }

    /**
     * Get without trashed of the items in the collection.
     *
     * @return array
     */
    public function withoutTrashed()
    {
        return (new static)->collection->filter(function ($item) {
            return blank($item[self::DELETED_AT] ?? null);
        });
    }
}
