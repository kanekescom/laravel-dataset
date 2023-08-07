<?php

namespace Kanekescom\Dataset;

trait TimestampsResolver
{
    /**
     * To resolve timestamps attributes.
     *
     * @param array $array
     */
    protected function timestampsResolver($array): array
    {
        if (isset($array[self::CREATED_AT])) {
            $array[self::CREATED_AT] = $array[self::CREATED_AT] ?: null;
        }

        if (isset($array[self::UPDATED_AT])) {
            $array[self::UPDATED_AT] = $array[self::UPDATED_AT] ?: null;
        }

        if (isset($array[self::DELETED_AT])) {
            $array[self::DELETED_AT] = $array[self::DELETED_AT] ?: null;
        }

        return $array;
    }
}
