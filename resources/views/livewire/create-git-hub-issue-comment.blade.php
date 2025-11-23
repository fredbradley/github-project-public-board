<div><h2 class="text-base font-semibold pt-5 pb-2">Comments</h2>
    <div class="space-y-5">
        @foreach ($comments as $comment)
            <x-panel title="{{ $comment['user']['login'] }}">
                <x-slot name="meta">{{ \Carbon\Carbon::parse($comment['updated_at'])->diffForHumans() }}</x-slot>
                <x-markdown :options="['html_input' => 'allow']">{!! $comment['body'] !!}</x-markdown>
            </x-panel>
        @endforeach
        <textarea placeholder="Comment" class="textarea textarea-error w-full" wire:model="comment"></textarea>
        <button wire:click="submit()" class="btn btn-neutral">Submit</button>

    </div>
</div>
