<?php

namespace App\Livewire;

use App\Services\CachedGithubService;
use Livewire\Component;

class CreateGitHubIssueComment extends Component
{
    public array $comments = [];

    public string $comment = '';

    public ?string $url = null;

    public function mount(string $url): void
    {
        $this->url = $url;
        $this->loadComments();
    }

    private function githubService()
    {
        return app()->make(CachedGithubService::class);
    }

    public function render()
    {
        return view('livewire.create-git-hub-issue-comment');
    }

    public function loadComments(): void
    {
        $this->comments = $this->githubService()->getApiResponseFromUrl($this->url)->toArray();
    }

    public function submit(): void
    {
        $this->githubService()->postComment($this->url, $this->comment);

        $this->comments = $this->githubService()->getUnCachedFromUrl($this->url)->toArray();
    }
}
