<?php

namespace Kanekescom\Dataset;

use League\Csv\Reader;

trait ReadFromCsv
{
    /**
     * Get CSV path.
     */
    protected function getCsvPath(): string
    {
        return $this->csvPath;
    }

    /**
     * Get the delimiter CSV.
     */
    protected function getCsvDelimiter(): string
    {
        return $this->csvDelimiter ?? ';';
    }

    /**
     * Read to CSV file.
     */
    protected function readCsv()
    {
        return Reader::createFromPath($this->getCsvPath())
            ->setDelimiter($this->getCsvDelimiter())
            ->setHeaderOffset(0);
    }

    /**
     * Get header from CSV.
     */
    protected function getCsvHeader(): array
    {
        return $this->readCsv()
            ->getHeader();
    }

    /**
     * Get records from CSV.
     */
    protected function getCsvRecords(): array
    {
        return iterator_to_array(
            $this->readCsv()
                ->getRecords(),
            true
        );
    }
}
