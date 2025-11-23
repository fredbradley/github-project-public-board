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
