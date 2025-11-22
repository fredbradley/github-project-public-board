<?php

namespace App\Data;

use App\Data\Enums\ItemContentType;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class BoardItemData extends Data
{
    public int $number;
    public CarbonImmutable $updated_at;

    public function __construct(
        public int $id,
        string $node_id,
        string $project_url,
        public ItemContentData $content,
        #[MapInputName('content_type')]
        public ItemContentType $contentType,
        public ItemCreatorData $creator,
        string $created_at,
        string $updated_at,
        ?string $archived_at,
        string $item_url,
        array $fields

    ) {
        $this->number = $this->content->number;
        $this->updated_at = CarbonImmutable::parse($updated_at);
    }
}
