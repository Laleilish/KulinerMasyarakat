@props([
    'id',
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'required' => true,
    'autofocus' => false,
    'disabled' => false,
    'readonly' => false,
    'value' => null,
    'helpText' => null,
])

<div>
    <label for="{{ $id }}" class="block text-sm font-semibold text-gray-700 mb-2">
        {{ $label }}
        @if(!$required)
            <span class="text-gray-400 text-xs">(opsional)</span>
        @endif
    </label>
    
    <input
        id="{{ $id }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value ?? old($name) }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        @if($autofocus) autofocus @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white/70 backdrop-blur-sm focus:border-muted focus:bg-white focus:ring-0 text-gray-800 placeholder:text-gray-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed']) }}
    />
    
    @if($helpText)
        <p class="mt-1 text-xs text-gray-500">{{ $helpText }}</p>
    @endif
    
    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
