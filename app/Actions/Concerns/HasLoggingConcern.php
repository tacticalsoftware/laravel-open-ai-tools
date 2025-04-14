<?php

namespace Tactical\OpenAiTools\Actions\Concerns;

use function Tactical\OpenAiTools\fmt;

trait HasLoggingConcern
{
    public function log(string $message): void
    {
        if ($this->config('logging.enabled')) {
            logger()->info(fmt('%: %', static::class, $message));
        }
    }

    abstract public function config(?string $key = null);
}
