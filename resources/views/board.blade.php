<x-layouts.app :title="__('Dashboard')">
    <div class="float-right">
        <x-view-on-github-button iconType="dark"
                                 url="{{ \App\Services\CachedGithubService::projectHtmlUrl($board['number']) }}"/>
    </div>
    <flux:heading level="1" size="xl">{{ $board['title'] }}</flux:heading>

    <div class="my-5">
        <flux:heading level="2" size="lg">{{ $board['short_description'] }}</flux:heading>
    </div>


    <flux:callout.text>
        <x-markdown>{{ $board['description'] }}</x-markdown>
    </flux:callout.text>

    @if ($board['latest_status_update'])
        <div class="card bg-gray-100 p-5 my-5">
            <div class="flex items-start justify-between gap-4">
                <!-- main content grows -->
                <div class="flex-1 pr-4">
                    <flux:heading level="2" size="lg" class="pb-2">
                        Latest Update
                    </flux:heading>

                    <x-markdown class="block">
                        {{ $board['latest_status_update']['body'] }}
                    </x-markdown>
                </div>

                <!-- avatar sits top-right of the card but inside the flow -->
                <div class="shrink-0 self-start">
                    <flux:avatar
                        class=""
                        size="xl"
                        tooltip="{{ $board['latest_status_update']['creator']['login'] }}"
                        src="{{ $board['latest_status_update']['creator']['avatar_url'] }}"
                    />
                </div>
            </div>
        </div>
    @endif
    <div class="space-y-5">
        @foreach ([$items, $completedItems] as $table)

            <x-github-project-table :table="$table" :boardId="$boardId"/>

        @endforeach
    </div>
</x-layouts.app>
