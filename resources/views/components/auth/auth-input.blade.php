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
    
    @if($type === 'password')
    <div class="relative">
    @endif

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
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white/70 backdrop-blur-sm focus:border-muted focus:bg-white focus:ring-0 text-gray-800 placeholder:text-gray-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed [&::-ms-reveal]:hidden [&::-ms-clear]:hidden [&::-webkit-credentials-auto-fill-button]:hidden' . ($type === 'password' ? ' pr-12' : '')]) }}
    />

    @if($type === 'password')
        <button type="button"
                onclick="(function(btn){
                    const input = btn.parentElement.querySelector('input');
                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    btn.querySelector('.eye-open').classList.toggle('hidden', !isPassword);
                    btn.querySelector('.eye-closed').classList.toggle('hidden', isPassword);
                })(this)"
                class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600 transition-colors">
            {{-- Eye closed (default - password is hidden) --}}
            <svg class="eye-closed w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12c1.292 4.338 5.31 7.5 10.066 7.5.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
            </svg>
            {{-- Eye open (shown when password is visible) --}}
            <svg class="eye-open w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </button>
    </div>
    @endif
    
    @if($helpText)
        <p class="mt-1 text-xs text-gray-500">{{ $helpText }}</p>
    @endif
    
    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
