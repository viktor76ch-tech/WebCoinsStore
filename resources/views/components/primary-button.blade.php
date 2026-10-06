<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-coffee']) }}>
    {{ $slot }}
</button>
