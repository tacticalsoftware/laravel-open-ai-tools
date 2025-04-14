<?php

namespace Tactical\OpenAiTools\Actions\KnowledgeBase;

use OpenAI\Responses\VectorStores\VectorStoreDeleteResponse;
use Tactical\OpenAiTools\Actions\Concerns\EnsuresVectorStoreConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasConfigConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasLoggingConcern;
use Tactical\OpenAiTools\Models\Contracts\HasAssistant;
use Tactical\OpenAiTools\Services\OpenAiService;

use function Tactical\OpenAiTools\fmt;

class DeleteVectorStoreAction
{
    use EnsuresVectorStoreConcern;
    use HasConfigConcern;
    use HasLoggingConcern;

    public function __invoke(HasAssistant $model): VectorStoreDeleteResponse
    {
        $vectorStoreId = $this->ensureVectorStore($model)->id;

        $this->log(fmt('deleting vector store % for assistant %', $vectorStoreId, $model->assistant->id));

        /** @var OpenAiService $service */
        $service = app(OpenAiService::class);

        return $service->vectorStores()->delete($vectorStoreId);
    }
}
