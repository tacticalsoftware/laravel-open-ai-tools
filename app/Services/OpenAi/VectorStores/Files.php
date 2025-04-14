<?php

namespace Tactical\OpenAiTools\Services\OpenAi\VectorStores;

use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileDeleteResponse;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileListResponse;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileResponse;

class Files
{
    public function list(string $vectorStoreId, int $limit = 100, ?string $after = null): VectorStoreFileListResponse
    {
        $params = [
            'limit' => $limit,
        ];

        if (is_string($after)) {
            $params['after'] = $after;
        }

        return OpenAI::vectorStores()->files()->list($vectorStoreId, $params);
    }

    public function delete(string $vectorStoreId, string $fileId): VectorStoreFileDeleteResponse
    {
        return OpenAI::vectorStores()->files()->delete(
            vectorStoreId: $vectorStoreId,
            fileId: $fileId,
        );
    }

    public function add(string $vectorStoreId, string $fileId): VectorStoreFileResponse
    {
        return OpenAI::vectorStores()->files()->create(
            vectorStoreId: $vectorStoreId,
            parameters: [
                'file_id' => $fileId,
            ]
        );
    }
}
