<?php

namespace Tactical\OpenAiTools\Enums;

enum ActionsEnum: string
{
    case DeleteUnlinkedFiles = 'delete-unlinked-files';
    case DeleteVectorStore = 'delete-vector-store';
    case EmptyVectorStore = 'empty-vector-store';
    case EnsureVectorStore = 'ensure-vector-store';
    case RenameVectorStore = 'rename-vector-store';
    case UploadFiles = 'upload-files';
}
