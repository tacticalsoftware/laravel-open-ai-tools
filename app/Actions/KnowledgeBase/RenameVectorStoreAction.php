<?php

namespace Tactical\OpenAiTools\Actions\KnowledgeBase;

use OpenAI\Responses\VectorStores\VectorStoreResponse;
use Tactical\OpenAiTools\Actions\Concerns\EnsuresVectorStoreConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasConfigConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasLoggingConcern;
use Tactical\OpenAiTools\Models\Contracts\HasAssistant;
use Tactical\OpenAiTools\Services\OpenAiService;

use function Tactical\OpenAiTools\fmt;

class RenameVectorStoreAction
{
    use EnsuresVectorStoreConcern;
    use HasConfigConcern;
    use HasLoggingConcern;

    public function __invoke(HasAssistant $model, string $newName): VectorStoreResponse
    {
        $vectorStoreId = $this->ensureVectorStore($model)->id;

        $this->log(fmt('renaming vector store for assistant % to %', $model->assistant->id, $vectorStoreId));

        /** @var OpenAiService $service */
        $service = app(OpenAiService::class);

        return $service->vectorStores()->rename($vectorStoreId, $newName);
    }
}
