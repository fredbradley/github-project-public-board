<div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <table class="table table-pin-cols">
        <thead>
        <th>Title</th>
        <th>Issue Type</th>
        <th>Labels</th>
        <th>Project</th>
        <th>Status</th>
        <th>Last Updated</th>
        </thead>
        <tbody>
        @foreach($table as $key => $item)
            @if ($item->content->state==='closed')
                <tr class="bg-rose-50">
            @else
                <tr>
                    @endif
                    <td><a href="{{ route('board.item', [$boardId, $item->id]) }}">
                            {{ $item->content->title }}
                        </a>
                    </td>
                    <td>
                        @php
                            $bg = $item->content?->type['color'] ?? '' ? colorNameToHex($item->content?->type['color']) : null;
                            $textColor = $bg ? suggestTextColor($bg) : null;
                        @endphp

                        <div class="flex">
                            <span class="px-2 py-1 rounded-xl font-extrabold"
                                  style="color: {{ $textColor ?? 'black' }};background: {{ $bg }};">{{ $item->content?->type['name']??'' }}</span>
                        </div>
                    </td>
                    <td class="">
                        <div class="flex flex-wrap gap-1">
                            @foreach ($item->content->labels as $label)
                                @php
                                    $textColor = suggestTextColor($label['color']);
                                @endphp
                                <span class="px-2 py-1 rounded-xl font-extrabold"
                                      style="color:{{ $textColor }};background:#{{ $label['color'] }};">{{ $label['name'] }}</span>
                            @endforeach
                        </div>
                    </td>

                    <td>
                        {{ Str::title(str_replace('-', ' ', $item->content->repo_name)) }}
                    </td>
                    <td>{{ Str::title($item->content->state_reason ? $item->content->state_reason : $item->content->state) }}</td>
                    <td>{{ $item->updated_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>
