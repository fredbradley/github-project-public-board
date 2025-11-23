@props([
    'title' => 'Unknown Title',
    ])
<div class="py-2 grid grid-cols-1 sm:grid-cols-3 gap-3">
    <dt class="text-sm font-medium text-gray-500 items-center">
        {{ $title }}
    </dt>
    <dd class="text-sm text-gray-900 sm:col-span-2">
        {{ $slot }}
    </dd>
</div>
