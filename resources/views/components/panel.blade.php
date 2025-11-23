<div {{ $attributes->merge(['class' => 'rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 flex flex-col']) }}>

    {{-- header --}}
    @if (isset($title))
        <div class="px-4 py-3 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                <h2 class="text-base font-semibold">
                    {{ $title }}
                </h2>

                @isset($meta)
                    <div class="text-sm text-neutral-500 dark:text-neutral-400">
                        {{ $meta }}
                    </div>
                @endisset
            </div>
        </div>
    @endif

    {{-- body --}}
    <div class="flex-1 {{ $paddingLess ?? null ? 'p-0' : 'p-4' }}">
        {{ $slot }}
    </div>

    {{-- footer --}}
    @if (isset($footer))
        <div class="px-4 py-3 border-t border-neutral-200 dark:border-neutral-700 flex gap-3">
            {{ $footer ?? '' }}
        </div>
    @endif

</div>
