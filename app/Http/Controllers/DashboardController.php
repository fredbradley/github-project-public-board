<?php

namespace App\Http\Controllers;

use App\Services\CachedGithubService;

class DashboardController extends Controller
{
    public function __invoke(CachedGithubService $cachedGithubService): \Illuminate\Contracts\View\View
    {
        $api = new BoardItemsController($cachedGithubService);

        return $api->index(config('services.github.default_project_id'));
    }
}
