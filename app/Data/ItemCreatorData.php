<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;


class ItemCreatorData extends Data
{
    public function __construct(
        #[MapInputName('login')]
        public string $username,
        int $id,
        string $node_id,
        #[MapInputName('avatar_url')]
        public string $avatarUrl,
    ) {

    }
}
