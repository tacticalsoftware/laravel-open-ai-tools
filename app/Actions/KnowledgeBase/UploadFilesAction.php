<?php

namespace Tactical\OpenAiTools\Actions\KnowledgeBase;

use Tactical\OpenAiTools\Actions\Concerns\EnsuresVectorStoreConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasConfigConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasLoggingConcern;
use Tactical\OpenAiTools\Collections\StringCollection;
use Tactical\OpenAiTools\Models\Contracts\HasAssistant;
use Tactical\OpenAiTools\Services\OpenAiService;
use Throwable;

use function Tactical\OpenAiTools\fmt;

class UploadFilesAction
{
    use EnsuresVectorStoreConcern;
    use HasConfigConcern;
    use HasLoggingConcern;

    public function __invoke(HasAssistant $model, StringCollection $files): void
    {
        $vectorStoreId = $this->ensureVectorStore($model)->id;

        /** @var OpenAiService $service */
        $service = app(OpenAiService::class);

        foreach ($files->all() as $file) {
            $response = null;

            try {
                $this->log(fmt('uploading file %', $file));

                $response = $service->files()->upload($file);
                $service->vectorStores()->files()->add($vectorStoreId, $response->id);
            } catch (Throwable) {
                // oops, file not uploaded
            }
        }
    }
}
