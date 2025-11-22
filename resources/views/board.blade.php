<x-layouts.app :title="__('Dashboard')">

    <x-view-on-github-button iconType="dark" url="{{ \App\Services\CachedGithubService::projectHtmlUrl($board['number']) }}" containingClass="float-right"/>

    <flux:heading level="1" size="xl">{{ $board['title'] }}</flux:heading>

    <flux:heading level="2" size="lg">{{ $board['short_description'] }}</flux:heading>
    <hr/>
    <flux:callout.text>
        <x-markdown>{{ $board['description'] }}</x-markdown>
    </flux:callout.text>
    <hr/>
    @if ($board['latest_status_update'])
        <div class="card">
            <flux:heading level="2" size="xl">Latest Update</flux:heading>
            <div class="flex items-start gap-3">
                <div class="prose flex-1">
                    <x-markdown>{{ $board['latest_status_update']['body'] }}</x-markdown>
                </div>
                <div class="shrink-0">
                    <flux:avatar
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
