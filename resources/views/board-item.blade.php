<x-layouts.app :title="__($item['content']['title'])">
{{--{{ dd($item) }}--}}
    <x-view-on-github-button url="{{ $item['content']['html_url'] }}" containingClass="float-right"/>
    <flux:heading level="1" size="xl">{{ $item['content']['title'] }}</flux:heading>
    <div class="clear-both">&nbsp;</div>
    <div class="grid grid-cols-12 gap-5">
        <div class="col-span-8">
            <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
                <div
                    class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <x-markdown>{{ $item['content']['body'] }}</x-markdown>
                </div>
            </div>
        </div>
        <div class="col-span-4">
            <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
                <div
                    class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <dl class="divide-y divide-gray-200">
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Type
                            </dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">
                                {{ $item['content_type'] }} <a href="{{ $item['content']['html_url'] }}" target="_blank">#{{ $item['content']['number'] }}</a>
                            </dd>
                        </div>

                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Type
                            </dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">
                                {{ $item['content']['type']['name'] ?? 'Not Set' }}
                            </dd>
                        </div>
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Labels
                            </dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($item['content']['labels'] as $label)
                                        @php
                                            $textColor = suggestTextColor($label['color']);
                                        @endphp
                                        <span class="px-2 py-1 rounded-xl font-extrabold"
                                              style="color:{{ $textColor }};background:#{{ $label['color'] }};">{{ $label['name'] }}</span>
                                    @endforeach
                                </div>
                            </dd>
                        </div>

                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Created
                            </dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">
                                {{ \Carbon\Carbon::parse($item['content']["created_at"])->diffForHumans() }}
                            </dd>
                        </div>
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Last Updated
                            </dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">
                                {{ \Carbon\Carbon::parse($item['content']["updated_at"])->diffForHumans() }}
                            </dd>
                        </div>
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Repository
                            </dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">
                                <a href="{{ $item['content']['repository']['html_url'] }}" target="_blank">{{ $item['content']["repository"]['name'] }}</a>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
