<?php

namespace Tactical\OpenAiTools\Actions\KnowledgeBase;

use OpenAI\Responses\VectorStores\VectorStoreResponse;
use Tactical\OpenAiTools\Actions\Concerns\HasConfigConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasLoggingConcern;
use Tactical\OpenAiTools\Models\Contracts\HasAssistant;
use Tactical\OpenAiTools\Services\OpenAIService;
use Throwable;

use function Tactical\OpenAiTools\fmt;

class EnsureVectorStoreAction
{
    use HasConfigConcern;
    use HasLoggingConcern;

    private static array $cache = [];

    public function __invoke(HasAssistant $model): VectorStoreResponse
    {
        /** @var OpenAiService $service */
        $service = app(OpenAiService::class);

        if (is_null($model->assistant)) {
            $model->assistant()->create();
            $model->refresh();
        }

        $assistantId = $model->assistant->id;
        $vectorStoreId = $model->assistant->open_ai_vector_store_id;

        if (is_null($vectorStoreId)) {
            make_vector_store_anyway:

            $this->log(fmt('creating vector store for assistant %', $assistantId));
            $response = $service->vectorStores()->create($model->getOpenAiVectorStoreName());

            $model->assistant->open_ai_vector_store_id = $response->id;
            $model->assistant->saveQuietly();

            return $response;
        }

        try {
            if (! isset($cache[$vectorStoreId])) {
                $cache[$vectorStoreId] = $service->vectorStores()->get($vectorStoreId);
            }

            return $cache[$vectorStoreId];
        } catch (Throwable) {
            $this->log(fmt('error loading vector store % for assistant %', $vectorStoreId, $assistantId));
            goto make_vector_store_anyway;
        }
    }
}
