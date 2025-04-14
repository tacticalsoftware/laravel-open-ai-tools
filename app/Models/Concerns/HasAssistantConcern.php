<?php

namespace Tactical\OpenAiTools\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Tactical\OpenAiTools\Models\Assistant;

use function Tactical\OpenAiTools\fmt;

/**
 * @property-read Assistant|null $assistant
 */
trait HasAssistantConcern
{
    public function assistant(): MorphOne
    {
        return $this->morphOne(Assistant::class, 'assistable');
    }

    public function getOpenAiAssistantName(): string
    {
        return $this->name
            ?? $this->title
            ?? $this->label
            ?? fmt('Assistant #%', $this->id);
    }

    public function getOpenAiVectorStoreName(): string
    {
        return $this->name
            ?? $this->title
            ?? $this->label
            ?? fmt('Vector Store #%', $this->id);
    }
}
