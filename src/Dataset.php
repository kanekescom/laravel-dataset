<?php

namespace Kanekescom\Dataset;

use Illuminate\Support\Collection;

class Dataset
{
    /**
     * Hardcoded array rows.
     */
    protected $rows = [];

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     */
    public function __call($method, $parameters): Collection
    {
        $collection = Collection::make((new static)->getRows());

        if ($this->hasTrait('Kanekescom\Dataset\TimestampsResolver')) {
            return $collection->map(function ($item) {
                return $this->timestampsResolver($item);
            });
        }

        return $collection;
    }

    /**
     * Handle dynamic static method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     */
    public static function __callStatic($method, $parameters): Collection
    {
        return (new static)->$method(...$parameters);
    }

    /**
     * Check the class using the given trait.
     */
    protected function hasTrait(string $traitName): bool
    {
        return in_array($traitName, class_uses($this));
    }

    /**
     * Get header depending on the trait used.
     */
    public function getHeader(): array
    {
        if ($this->hasTrait('Kanekescom\Dataset\ReadFromCsv')) {
            return $this->getCsvHeader();
        }

        return [];
    }

    /**
     * Get rows depending on the trait used.
     */
    public function getRows(): array
    {
        if ($this->hasTrait('Kanekescom\Dataset\ReadFromCsv')) {
            return $this->getCsvRecords();
        }

        return $this->rows;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     */
    public static function header(): Collection
    {
        return Collection::make((new static)->getHeader());
    }
}
