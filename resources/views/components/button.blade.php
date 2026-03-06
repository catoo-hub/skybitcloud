@props([
	'variant' => 'primary',
	'href' => null,
	'action' => null,
	'method' => 'POST',
	'type' => 'button',
	'disabled' => false,
])

@php
	$variantClasses = [
		'primary' => 'bg-white/10 text-white border border-white/10 hover:bg-transparent hover:text-white',
		'secondary' => 'bg-transparent text-white border border-white/10 hover:bg-white hover:text-black',
		'ghost' => 'bg-transparent text-white border border-transparent hover:border-white',
		'danger' => 'bg-red-600 text-white border border-red-600 hover:bg-red-700 hover:border-red-700',
	];

	$baseClasses = 'inline-flex items-center justify-center p-[8px] gap-[6px] rounded-[12px] font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70 disabled:opacity-50 disabled:cursor-not-allowed';
	$classes = trim($baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']));

	$hasHref = filled($href);
	$hasFormAction = filled($action);
	$httpMethod = strtoupper($method);
	$formMethod = in_array($httpMethod, ['GET', 'POST'], true) ? $httpMethod : 'POST';
@endphp

@if($hasFormAction)
	<form method="{{ $formMethod }}" action="{{ $action }}" class="inline-block">
		@if($formMethod !== 'GET')
			@csrf
		@endif

		@if(!in_array($httpMethod, ['GET', 'POST'], true))
			@method($httpMethod)
		@endif

		<button type="submit" {{ $attributes->class($classes)->merge(['disabled' => $disabled]) }}>
			{{ $slot }}
		</button>
	</form>
@elseif($hasHref)
	<a href="{{ $href }}" {{ $attributes->class($classes) }}>
		{{ $slot }}
	</a>
@else
	<button type="{{ $type }}" {{ $attributes->class($classes)->merge(['disabled' => $disabled]) }}>
		{{ $slot }}
	</button>
@endif