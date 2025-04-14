<?php

namespace Tactical\OpenAiTools\Services\OpenAi;

use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Files\CreateResponse;
use OpenAI\Responses\Files\DeleteResponse;
use OpenAI\Responses\Files\ListResponse;

class Files
{
    public function delete(string $fileId): DeleteResponse
    {
        return OpenAI::files()->delete($fileId);
    }

    public function list(int $limit = 100, ?string $after = null): ListResponse
    {
        $params = [
            'limit' => $limit,
        ];

        if (is_string($after)) {
            $params['after'] = $after;
        }

        return OpenAI::files()->list($params);
    }

    public function upload(string $path, string $purpose = 'assistants'): CreateResponse
    {
        return OpenAI::files()->upload([
            'purpose' => $purpose,
            'file' => fopen($path, 'r'),
        ]);
    }
}
