<?php

namespace Tactical\OpenAiTools\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Tactical\OpenAiTools\Models\Assistant;

/**
 * @property-read Assistant|null $assistant
 *
 * @mixin Model
 */
interface HasAssistant
{
    public function assistant(): MorphOne;

    public function getOpenAiAssistantName(): string;

    public function getOpenAiVectorStoreName(): string;
}
