@props(['title'])

<div>
    <h2 class="text-sm font-medium text-gray-600 mb-3">{{ $title }}</h2>
    {{ $slot }}
</div>
