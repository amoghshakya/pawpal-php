@props(['name'])
@error($name)
    <span class="text-xs/snug font-semibold text-red-500">{{ $message }}</span>
@enderror
