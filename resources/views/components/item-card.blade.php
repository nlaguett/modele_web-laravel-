@props([
    'theme',
    'title',
    'subtitle' => null,
    'showStatus' => false,
    'status' => null,
    'description' => null
])

<div class="item-card theme-{{ $theme }}" {{ $attributes }}>
    {{-- Header --}}
    <div class="item-header">
        <div>
            <div class="item-title">{{ $title }}</div>
            @if($subtitle)
                <div class="item-reference">{{ $subtitle }}</div>
            @endif
        </div>

        @if($showStatus)
            <div class="status-badge status-{{ $status ? '' : 'in' }}active">
                {{ $status ? 'Actif' : 'Inactif' }}
            </div>
        @endif
    </div>

    {{-- Description (optionnelle) --}}
    @if($description)
        <div class="item-description">{{ $description }}</div>
    @endif

    {{-- Section Contact (optionnelle) --}}
    @if(isset($contact))
        <div class="contact-section">
            {{ $contact }}
        </div>
    @endif

    {{-- Section Adresse (optionnelle) --}}
    @if(isset($address))
        <div class="address-section">
            {{ $address }}
        </div>
    @endif

    {{-- Détails personnalisés via slot --}}
    @if(isset($details))
        <div class="item-details {{ isset($fullWidth) ? 'full-width' : '' }}">
            {{ $details }}
        </div>
    @endif

    {{-- Section Observations (optionnelle) --}}
    @if(isset($observations))
        <div class="observations-section">
            {{ $observations }}
        </div>
    @endif

    {{-- Actions personnalisées via slot --}}
    @if(isset($actions))
        <div class="item-actions">
            {{ $actions }}
        </div>
    @endif
</div>
