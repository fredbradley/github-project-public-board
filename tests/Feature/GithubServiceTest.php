<?php

use App\Services\CachedGithubService;
use Illuminate\Support\Facades\Cache;

it('returns board data from cache', function () {
    $service = new CachedGithubService;
    $boardId = 123;
    $expected = collect(['id' => $boardId, 'title' => 'Test Board']);

    Cache::shouldReceive('remember')
        ->once()
        ->withArgs(function ($key, $ttl, $callback) use ($boardId) {
            return $key === 'getBoard'.$boardId;
        })
        ->andReturn($expected);

    $result = $service->getBoard($boardId);

    expect($result)->toEqual($expected);
});

it('returns board items by state', function () {
    $service = Mockery::mock(CachedGithubService::class)->makePartial();
    $boardId = 123;
    $items = collect([
        (object) ['content' => (object) ['state' => 'open']],
        (object) ['content' => (object) ['state' => 'closed']],
    ]);

    $service->shouldReceive('getAllBoardItems')
        ->with($boardId)
        ->andReturn($items);

    $result = $service->getBoardItems($boardId);

    expect($result->pluck('content.state')->contains('closed'))->toBeFalse();
});
