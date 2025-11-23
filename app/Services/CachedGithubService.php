<?php

namespace App\Services;

use App\Data\BoardItemData;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CachedGithubService
{
    public int $ttl = 15 * 60; // Cache lifetime in seconds (currently 15 minutes)

    public static function apiBase(): string
    {
        return '/orgs/'.config('services.github.org').'/projectsV2/';
    }

    public static function projectHtmlUrl(int $number): string
    {
        return 'https://github.com/orgs/'.config('services.github.org').'/projects/'.$number;
    }

    protected function getBoardItemsByState(int $boardId, string $state, bool $keep = true): Collection
    {
        return $this->getAllBoardItems($boardId)->filter(function ($item) use ($state, $keep) {
            return $keep
                ? $item->content->state === $state
                : $item->content->state !== $state;
        });

    }

    public function getBoardsForNavigation(): Collection
    {
        return $this->listBoards()->map(function (array $item) {
            return [
                'title' => $item['title'],
                'number' => $item['number'],
            ];
        });
    }

    public function listBoards(): Collection
    {
        return Cache::remember(__FUNCTION__, $this->ttl, function () {
            return Http::github()->get(rtrim(self::apiBase(), '/'))
                ->throw()
                ->collect()
                ->filter(function (array $item) {
                    return $item['state'] === 'open' && is_null($item['closed_at']);
                })->values();
        });
    }

    public function getBoard(int $boardId): Collection
    {
        return Cache::remember(__FUNCTION__.$boardId, $this->ttl, function () use ($boardId) {
            return Http::github()->get(self::apiBase()."{$boardId}")
                ->throw()
                ->collect();
        });
    }

    public function getBoardItems(int $boardId): Collection
    {
        return $this->getBoardItemsByState($boardId, 'closed', false);
    }

    public function getCompletedBoardItems(int $boardId): Collection
    {
        return $this->getBoardItemsByState($boardId, 'closed', true);
    }

    public function getAllBoardItems(int $boardId, array $options = []): Collection
    {
        $response = Cache::remember(__FUNCTION__.$boardId, $this->ttl, function () use ($boardId, $options) {
            return Http::github()->get(self::apiBase()."{$boardId}/items", array_merge([
                'per_page' => 100,
            ], $options))
                ->throw()
                ->collect();
        });

        return BoardItemData::collect($response);
    }

    public function getCustomFields(int $boardId): Collection
    {
        return Cache::remember(__FUNCTION__.$boardId, $this->ttl, function () use ($boardId) {
            return Http::github()
                ->get(self::apiBase()."{$boardId}/fields")
                ->throw()
                ->collect();
        });
    }

    public function postComment(string $url, string $comment): Response
    {
        $username = auth()->user()?->name ?? 'Unknown User';

        $comment = sprintf('<b>%s comments:</b><br /><br />%s', $username, $comment);

        return Http::github()->post($url, [
            'body' => $comment,
        ])->throw();
    }

    public function getUnCachedFromUrl(string $url): Collection
    {
        return Http::github()->get($url)->throw()->collect();
    }

    public function getApiResponseFromUrl(string $url): Collection
    {
        return Cache::remember(
            __FUNCTION__.$url,
            $this->ttl,
            function () use ($url) {
                return $this->getUnCachedFromUrl($url);
            });
    }

    public function getIssueComments(string $owner, string $repo, int $number): Collection
    {
        return Cache::remember(
            __FUNCTION__.$owner.'/'.$repo.'/'.$number,
            $this->ttl,
            function () use ($owner, $repo, $number) {
                return Http::github()
                    ->get("repos/{$owner}/{$repo}/issues/{$number}/comments")
                    ->throw()
                    ->collect();
            });
    }

    public function getBoardItem(int $boardId, int $itemId): Collection
    {
        return Cache::remember(__FUNCTION__.$boardId.$itemId, $this->ttl, function () use ($boardId, $itemId) {
            return Http::github()->get(self::apiBase()."{$boardId}/items/{$itemId}", [
                'fields' => $this->getCustomFields($boardId)->pluck('id')->implode(','),
            ])
                ->throw()
                ->collect();
        });
    }
}
