<?php

namespace Tactical\OpenAiTools\Services;

use Tactical\OpenAiTools\Services\OpenAi\Files;
use Tactical\OpenAiTools\Services\OpenAi\VectorStores;

class OpenAiService
{
    public function vectorStores(): VectorStores
    {
        return new VectorStores;
    }

    public function files(): Files
    {
        return new Files;
    }
}
