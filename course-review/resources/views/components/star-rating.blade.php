<?php
// Recibe un número como $rating (ej: 4.5) y un tamaño $size (ej: 'md')
$fullStars = floor($rating);
$halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
$emptyStars = 5 - $fullStars - $halfStar;

// Define el tamaño de la estrella
$sizeClass = match ($size ?? 'md') {
    'sm' => 'w-4 h-4',
    'lg' => 'w-6 h-6',
    default => 'w-5 h-5', // md
};
?>

{{-- Contenedor de las estrellas --}}
<div class="flex items-center text-yellow-500">
    {{-- Estrellas Rellenas --}}
    @for ($i = 0; $i < $fullStars; $i++)
        {{-- SVG de estrella completa --}}
        <svg class="{{ $sizeClass }} fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279L12 18.295l-7.416 3.818 1.48-8.279L.001 9.306l8.332-1.151z"/></svg>
    @endfor

    {{-- Media Estrella --}}
    @if ($halfStar)
        {{-- SVG de media estrella usando degradado --}}
        <svg class="{{ $sizeClass }} fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <defs><linearGradient id="half"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="currentColor" stop-opacity="0"/></linearGradient></defs>
            <path fill="url(#half)" d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279L12 18.295l-7.416 3.818 1.48-8.279L.001 9.306l8.332-1.151z"/>
        </svg>
    @endif

    {{-- Estrellas Vacías --}}
    @for ($i = 0; $i < $emptyStars; $i++)
        {{-- SVG de estrella vacía (solo borde) --}}
        <svg class="{{ $sizeClass }} fill-current text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 18.295l-7.416 3.818 1.48-8.279L.001 9.306l8.332-1.151L12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279L12 18.295zm0 2.22l-6.236 3.208 1.258-7.03-5.11-4.93 7.06-.975L12 2.05l2.028 4.195 7.06.975-5.11 4.93 1.258 7.03z"/></svg>
    @endfor
</div>