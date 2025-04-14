<?php

namespace Tactical\OpenAiTools\Services\OpenAi;

use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\VectorStores\VectorStoreDeleteResponse;
use OpenAI\Responses\VectorStores\VectorStoreResponse;
use Tactical\OpenAiTools\Services\OpenAi\VectorStores\Files;

class VectorStores
{
    public function files(): Files
    {
        return new Files;
    }

    public function create(string $name): VectorStoreResponse
    {
        return OpenAI::vectorStores()->create([
            'name' => $name,
        ]);
    }

    public function get(string $vectorStoreId): VectorStoreResponse
    {
        return OpenAI::vectorStores()->retrieve($vectorStoreId);
    }

    public function rename(string $vectorStoreId, string $newName): VectorStoreResponse
    {
        return OpenAI::vectorStores()->modify($vectorStoreId, [
            'name' => $newName,
        ]);
    }

    public function delete(string $vectorStoreId): VectorStoreDeleteResponse
    {
        return OpenAI::vectorStores()->delete($vectorStoreId);
    }
}
