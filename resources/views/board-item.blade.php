<x-layouts.app :title="__($item['content']['title'])">
    <div class="float-right">
        <a href="{{ route('board', $boardId) }}" class="btn btn-accent">Back to Board</a>
        <x-view-on-github-button url="{{ $item['content']['html_url'] }}" containingClass=""/>
    </div>
    <flux:heading level="1" size="xl">{{ $item['content']['title'] }}</flux:heading>
    <div class="clear-both">&nbsp;</div>
    <div class="grid grid-cols-12 gap-5">
        <div class="col-span-8">
            <x-panel title="{{ $item['content']['title'] }}">
                <x-markdown :options="['html_input' => 'allow']">
                    {!! $item['content']['body'] !!}</x-markdown>
            </x-panel>

                <livewire:create-git-hub-issue-comment url="{{ $item['content']['comments_url'] }}" />
        </div>
        <div class="col-span-4">
            <x-panel class="p-0">
                @include('partials.board-item-meta')
            </x-panel>
        </div>
    </div>
</x-layouts.app>
