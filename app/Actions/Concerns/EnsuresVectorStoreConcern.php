<?php

namespace Tactical\OpenAiTools\Actions\Concerns;

use OpenAI\Responses\VectorStores\VectorStoreResponse;
use Tactical\OpenAiTools\Actions\KnowledgeBase\EnsureVectorStoreAction;
use Tactical\OpenAiTools\Models\Contracts\HasAssistant;

trait EnsuresVectorStoreConcern
{
    public function ensureVectorStore(HasAssistant $model): VectorStoreResponse
    {
        /** @var EnsureVectorStoreAction $action */
        $action = app(EnsureVectorStoreAction::class);

        return $action($model);
    }
}
