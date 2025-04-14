<?php

namespace Tactical\OpenAiTools\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Tactical\OpenAiTools\Providers\OpenAiToolsProvider;

use function Tactical\OpenAiTools\fmt;

/**
 * @property int $id
 * @property string|null $open_ai_assistant_id
 * @property string|null $open_ai_vector_store_id
 * @property int $assistable_id
 * @property string $assistable_type
 * @property-read Model $assistable
 *
 * @method static Builder<static>|Assistant newModelQuery()
 * @method static Builder<static>|Assistant newQuery()
 * @method static Builder<static>|Assistant query()
 * @method static Builder<static>|Assistant whereAssistableId($value)
 * @method static Builder<static>|Assistant whereAssistableType($value)
 * @method static Builder<static>|Assistant whereId($value)
 * @method static Builder<static>|Assistant whereOpenAiAssistantId($value)
 * @method static Builder<static>|Assistant whereOpenAiVectorStoreId($value)
 */
class Assistant extends Model
{
    public function getTable(): string
    {
        return config(fmt('%.database.prefix', OpenAiToolsProvider::KEY)).'assistants';
    }

    public function assistable(): MorphTo
    {
        return $this->morphTo();
    }
}
