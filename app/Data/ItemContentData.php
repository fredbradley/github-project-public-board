<?php

namespace App\Data;

use Illuminate\Support\Optional;
use Spatie\LaravelData\Data;

class ItemContentData extends Data
{
    public string $repo_name;

    public function __construct(
        public string $url,
        int $id,
        string $node_id,
        public int $number,
        public string $title,
        public array $labels,
        public array $assignees,
        public ?array $milestone,
        public ?array $type,
        public ?string $body,
        public string $state,
        public ?string $state_reason,
        public string $created_at,
        public string $updated_at,
        public ?string $deleted_at,

        // The below are all 'optional'
        public array|\Spatie\LaravelData\Optional $head,
        public array|\Spatie\LaravelData\Optional $repository,
        public array|\Spatie\LaravelData\Optional $reactions,
        public array|\Spatie\LaravelData\Optional $sub_issues_summary,
        public array|\Spatie\LaravelData\Optional $issue_dependencies_summary
    ) {
        $this->repo_name = $head instanceof \Spatie\LaravelData\Optional
            ? $repository['name']
            : $head['repo']['name'];
    }
}
