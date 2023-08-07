<?php

namespace Kanekescom\Dataset;

use Illuminate\Support\Collection;

class Dataset
{
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $collection;


    /**
     * Hardcoded array rows.
     */
    protected $rows = [];

    public function __construct()
    {
        $this->collection = Collection::make($this->getRows())
            ->map(function ($item) {
                return $this->transform($item);
            });

        if ($this->hasTrait('Kanekescom\Dataset\TimestampsResolver')) {
            $this->collection = $this->collection->map(function ($item) {
                return $this->timestampsResolver($item);
            });
        }
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->collection, $method)) {
            return call_user_func_array([$this->collection, $method], $parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    /**
     * Handle dynamic static method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     */
    public static function __callStatic($method, $parameters)
    {
        if (method_exists((new static)->collection, $method)) {
            return call_user_func_array([(new static)->collection, $method], $parameters);
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
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
     * Get header.
     */
    public static function header(): Collection
    {
        return Collection::make((new static)->getHeader());
    }

    /**
     * To transform rows.
     *
     * @param  array  $item
     */
    protected function transform(array $item): array
    {
        return $item;
    }
}
