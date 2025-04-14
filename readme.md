# Laravel Open AI Tools

This is a small collection of tools we've used to build complex Open AI based applications. It may expand as we find more things the excellent underlying libraries don;t make easy enough out the box.

```sh
composer require tactical/laravel-open-ai-tools
```

At its core, the heavy lifting is done with invocable actions:

- `Tactical\OpenAiTools\Actions\KnowledgeBase\DeleteUnlinkedFilesAction`
- `Tactical\OpenAiTools\Actions\KnowledgeBase\DeleteVectorStoreAction`
- `Tactical\OpenAiTools\Actions\KnowledgeBase\EmptyVectorStoreAction`
- `Tactical\OpenAiTools\Actions\KnowledgeBase\EnsureVectorStoreAction`
- `Tactical\OpenAiTools\Actions\KnowledgeBase\RenameVectorStoreAction`
- `Tactical\OpenAiTools\Actions\KnowledgeBase\UploadFilesAction`

These operate on a polymorphic relationship, which you can attach to any of your models:

```php
class Project extends Model implements HasAssistant
{
    use HasAssistantConcern;
    
    // ...other nonsense
}
```

If a model has `HasAssistant` and `HasAssistantConcern`, then you can access a couple useful fields:

```php
$project->assistant()->create();
$project->assistant->open_ai_assistant_id; // → null|string
$project->assistant->open_ai_vector_store_id; // → null|string
```

The actions use this relationship to store Open AI identifiers without polluting your models. You don't actually need to create the assistant yourself. Each action calls `EnsureVectorStoreAction` under the hood, which creates any missing assistant models.

You can reference these actions directly:

```php
/** @var RenameVectorStoreAction $action */
$action = app(RenameVectorStoreAction::class);
$action($project, 'new project name');
```

Many assistant operations happen at the same time. For example, your application might require a complex knowledge base change:

1. creating a vector store if it's missing
2. saving the vector store ID to the database if just created
3. emptying the existing vector store of uploaded files
4. uploading a completely new set of files

This can lead to a mountain of boilerplate, and you might miss edge cases. We've made it easy to chain actions:

```php
/** @var OpenAiToolsService $service */
$service = app(OpenAiToolsService::class);

$service
    ->with($project)
    ->action(ActionsEnum::EmptyVectorStore)
    ->action(ActionsEnum::UploadFiles, $files);
```
