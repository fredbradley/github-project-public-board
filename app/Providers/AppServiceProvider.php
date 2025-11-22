<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('github', function () {
            $token = config('services.github.token');
            $client = Http::withToken($token)->withHeaders([
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'Laravel-GitHub-Client',
            ])->baseUrl('https://api.github.com');

            return $client;
        });
        Http::macro('githubGraphQL', function (string $query, array $variables) {
            return Http::withHeaders([
                'Accept' => 'application/vnd.github+json',
                'Authorization' => 'Bearer ' . env('GITHUB_TOKEN')
            ])->post('https://api.github.com/graphql', [
                'query' => $query,
                'variables' => $variables,
            ]);
        });
    }
}
