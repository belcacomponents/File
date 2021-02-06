<?php

namespace Dios\System\File\Models;

use Illuminate\Database\Eloquent\Collection;

/**
 * Extends the base collection by functions to handle instances of File.
 */
class FileCollection extends Collection
{
    /**
     * Returns files by the given driver.
     *
     * @param  string $driver
     * @return self
     */
    public function getByDriver(string $driver): self
    {
        return $this->where('driver', $driver);
    }

    /**
     * Returns a file by the given handler mode.
     *
     * @param  string $handler
     * @param  string $mode
     * @return File|null
     */
    public function getByHandlerMode(string $handler, string $mode): ?File
    {
        return $this->where('handler', $handler)->where('handler_mode', $mode)->first();
    }
}
