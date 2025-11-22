<x-layouts.app :title="__($item['content']['title'])">
    {{--{{ dd($item) }}--}}
    <div class="float-right">
        <a href="{{ route('board', $boardId) }}" class="btn btn-accent">Back to Board</a>
        <x-view-on-github-button url="{{ $item['content']['html_url'] }}" containingClass=""/>
    </div>
    <flux:heading level="1" size="xl">{{ $item['content']['title'] }}</flux:heading>
    <div class="clear-both">&nbsp;</div>
    <div class="grid grid-cols-12 gap-5">
        <div class="col-span-8">
            <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
                <div
                    class="px-3 py-3 relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <x-markdown>{{ $item['content']['body'] }}</x-markdown>
                </div>
            </div>
        </div>
        <div class="col-span-4">
            <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
                <div
                    class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <dl class="divide-y divide-gray-200">
                        <x-data-list title="Type">
                            {{ $item['content_type'] }} <a href="{{ $item['content']['html_url'] }}"
                                                           target="_blank">#{{ $item['content']['number'] }}</a>
                        </x-data-list>
                        @foreach ($customFields as $field)
                            <x-custom-field :item="$item" :field="$field"/>
                        @endforeach
                        <x-data-list title="Created">
                            {{ \Carbon\Carbon::parse($item['content']["created_at"])->diffForHumans() }}
                        </x-data-list>
                        <x-data-list title="Last Updated">
                            {{ \Carbon\Carbon::parse($item['content']["updated_at"])->diffForHumans() }}
                        </x-data-list>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
