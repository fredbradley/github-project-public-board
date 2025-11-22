@props([
    'title' => 'Unknown Title',
    ])
<div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
    <dt class="text-sm font-medium text-gray-500 pl-2">
        {{ $title }}
    </dt>
    <dd class="text-sm text-gray-900 sm:col-span-2 pr-2">
        {{ $slot }}
    </dd>
</div>
