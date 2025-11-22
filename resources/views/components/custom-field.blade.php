@props([
    'item',
    'field' => '',
])

@php
    $value = getCustomField($item['fields'], $field);
    $title = $field === 'Assignees' ? 'Assigned To' : $field;
@endphp

@if ($value)
    <x-data-list :title="$title">

        @switch($field)

            {{-- LABELS --}}
            @case('Labels')
                @if (is_array($value))
                    <div class="flex flex-wrap gap-1">
                        @foreach ($value as $label)
                            @php
                                $textColor = suggestTextColor($label['color']);
                            @endphp
                            <span class="px-2 py-1 rounded-xl font-extrabold"
                                  style="color:{{ $textColor }}; background:#{{ $label['color'] }};">
                                {{ $label['name'] }}
                            </span>
                        @endforeach
                    </div>
                @endif
                @break

                {{-- ASSIGNEES --}}
            @case('Assignees')
                @if (is_array($value))
                    <div class="flex flex-wrap gap-2">
                        @foreach ($value as $assignee)
                            <flux:avatar
                                size="sm"
                                tooltip="{{ $assignee['login'] }}"
                                src="{{ $assignee['avatar_url'] }}"
                                class="shrink-0"
                            />
                        @endforeach
                    </div>
                @endif
                @break

                {{-- DEFAULT (simple string or number) --}}
            @default
                {{ is_array($value) ? json_encode($value) : $value }}

        @endswitch
    </x-data-list>
@endif
