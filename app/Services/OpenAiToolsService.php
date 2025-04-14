<?php

namespace Tactical\OpenAiTools\Services;

use Tactical\OpenAiTools\Actions\KnowledgeBase\DeleteUnlinkedFilesAction;
use Tactical\OpenAiTools\Actions\KnowledgeBase\DeleteVectorStoreAction;
use Tactical\OpenAiTools\Actions\KnowledgeBase\EmptyVectorStoreAction;
use Tactical\OpenAiTools\Actions\KnowledgeBase\EnsureVectorStoreAction;
use Tactical\OpenAiTools\Actions\KnowledgeBase\RenameVectorStoreAction;
use Tactical\OpenAiTools\Actions\KnowledgeBase\UploadFilesAction;
use Tactical\OpenAiTools\Enums\ActionsEnum;
use Tactical\OpenAiTools\Models\Contracts\HasAssistant;

class OpenAiToolsService
{
    private ?HasAssistant $model = null;

    public function with(HasAssistant $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function action(ActionsEnum $action, ...$parameters): static
    {
        $action = app(match ($action) {
            ActionsEnum::DeleteUnlinkedFiles => DeleteUnlinkedFilesAction::class,
            ActionsEnum::DeleteVectorStore => DeleteVectorStoreAction::class,
            ActionsEnum::EmptyVectorStore => EmptyVectorStoreAction::class,
            ActionsEnum::EnsureVectorStore => EnsureVectorStoreAction::class,
            ActionsEnum::RenameVectorStore => RenameVectorStoreAction::class,
            ActionsEnum::UploadFiles => UploadFilesAction::class,
        });

        if (is_null($this->model)) {
            $action(...$parameters);
        } else {
            $action($this->model, ...$parameters);
        }

        return $this;
    }
}
