<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('make:default-user', function() {
    User::query()->updateOrCreate([
        'email' => 'admin@admin.com',
    ],[
        'password' => bcrypt('admin'),
        'name' => 'Default Admin User'
    ]);
});
