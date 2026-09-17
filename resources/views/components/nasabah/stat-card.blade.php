@props(['label', 'value', 'description' => '', 'symbol' => '◈'])
<article class="ns-card overflow-hidden p-6"><span class="ns-label">{{ $label }}</span><strong
        class="mt-2 block text-3xl leading-none">{{ $value }}</strong>@if($description)
        <p class="mt-2 text-sm text-[#6a5c52]">{{ $description }}</p>@endif
</article>
