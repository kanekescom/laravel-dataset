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
        if (isset($array['created_at'])) {
            $array['created_at'] = $array['created_at'] ?: null;
        }

        if (isset($array['updated_at'])) {
            $array['updated_at'] = $array['updated_at'] ?: null;
        }

        if (isset($array['deleted_at'])) {
            $array['deleted_at'] = $array['deleted_at'] ?: null;
        }

        return $array;
    }
}
