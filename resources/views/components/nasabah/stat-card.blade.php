@props([
    'label',
    'value',
    'description' => '',
    'icon' => 'bi-bar-chart-line',
    'descIcon' => 'bi-arrow-repeat',
    'accent' => '#92591f',
    'descColor' => '#695b51',
    'unit' => '',
])
<article class="ns-card border-t-4 p-5" style="border-top-color: {{ $accent }}">
    <div class="flex items-start justify-between gap-3">
        <span class="ns-label">{{ $label }}</span>
        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-[#f4ecd7] text-sm text-[#92591f]"><i
                class="bi {{ $icon }}"></i></span>
    </div>
    <strong class="mt-4 block text-3xl">{{ $value }}@if($unit)<small class="text-base font-normal"> {{ $unit }}</small>@endif</strong>
    @if($description)
        <small class="mt-1 block text-[11px]" style="color: {{ $descColor }}"><i class="bi {{ $descIcon }}"></i> {{ $description }}</small>
    @endif
</article>
