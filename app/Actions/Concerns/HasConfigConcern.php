<?php

namespace Tactical\OpenAiTools\Actions\Concerns;

use Tactical\OpenAiTools\Providers\OpenAiToolsProvider;

use function Tactical\OpenAiTools\fmt;

trait HasConfigConcern
{
    public function config(?string $key = null)
    {
        if (is_null($key)) {
            return config(fmt('%', OpenAiToolsProvider::KEY));
        }

        return config(fmt('%.%', OpenAiToolsProvider::KEY, $key));
    }
}
