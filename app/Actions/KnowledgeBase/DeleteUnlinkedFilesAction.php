<?php

namespace Tactical\OpenAiTools\Actions\KnowledgeBase;

use Tactical\OpenAiTools\Actions\Concerns\EnsuresVectorStoreConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasConfigConcern;
use Tactical\OpenAiTools\Actions\Concerns\HasLoggingConcern;
use Tactical\OpenAiTools\Collections\AssistableCollection;
use Tactical\OpenAiTools\Services\OpenAiService;

use function Tactical\OpenAiTools\fmt;

class DeleteUnlinkedFilesAction
{
    use EnsuresVectorStoreConcern;
    use HasConfigConcern;
    use HasLoggingConcern;

    public function __invoke(AssistableCollection $models): void
    {
        /** @var OpenAiService $service */
        $service = app(OpenAiService::class);

        $vectorStoreIds = [];

        foreach ($models->all() as $model) {
            $vectorStoreIds[] = $this->ensureVectorStore($model)->id;
        }

        $vectorStoreIds = array_filter($vectorStoreIds);

        $this->log(fmt('% vector stores to check', count($vectorStoreIds)));

        $linkedFileIds = [];
        $lastFileId = null;

        foreach (array_filter($vectorStoreIds) as $vectorStoreId) {
            do {
                $response = $service->vectorStores()->files()->list($vectorStoreId, after: $lastFileId);

                if (($count = count($response->data)) > 0) {
                    $this->log(fmt('% files found', $count));
                }

                foreach ($response->data as $nextRemote) {
                    $linkedFileIds[] = $lastFileId = $nextRemote->id;
                }
            } while ($count > 0);
        }

        $fileIds = [];
        $lastFileId = null;

        do {
            $response = $service->files()->list(after: $lastFileId);

            if (($count = count($response->data)) > 0) {
                $this->log(fmt('% vector store files found', $count));
            }

            foreach ($response->data as $nextRemote) {
                $fileIds[] = $lastFileId = $nextRemote->id;
            }
        } while ($count > 0);

        $unlinkedFileIds = array_diff($fileIds, $linkedFileIds);

        $this->log(fmt('% unlinked files to delete', count($unlinkedFileIds)));

        foreach ($unlinkedFileIds as $unlinkedFileId) {
            $service->files()->delete($unlinkedFileId);
        }
    }
}
