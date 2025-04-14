<?php

namespace Tactical\OpenAiTools\Actions\KnowledgeBase;

use Tactical\OpenAiTools\Actions\Concerns\EnsuresVectorStoreConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasConfigConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasLoggingConcern;
use Tactical\OpenAiTools\Models\Contracts\HasAssistant;
use Tactical\OpenAiTools\Services\OpenAiService;
use Throwable;

use function Tactical\OpenAiTools\fmt;

class EmptyVectorStoreAction
{
    use EnsuresVectorStoreConcern;
    use HasConfigConcern;
    use HasLoggingConcern;

    public function __invoke(HasAssistant $model): void
    {
        $vectorStoreId = $this->ensureVectorStore($model)->id;

        /** @var OpenAiService $service */
        $service = app(OpenAiService::class);

        do {
            $response = $service->vectorStores()->files()->list($vectorStoreId);

            if (($count = count($response->data)) > 0) {
                $this->log(fmt('% vector store files found', $count));
            }

            foreach ($response->data as $file) {
                try {
                    $this->log(fmt('deleting file %', $file->id));

                    $service->vectorStores()->files()->delete($vectorStoreId, $file->id);
                    $service->files()->delete($file->id);
                } catch (Throwable) {
                    // ...file was removed by someone else
                }
            }
        } while ($count > 0);
    }
}
