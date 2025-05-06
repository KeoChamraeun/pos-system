<div class="language-switcher">
    <div class="dropdown">
        <button class="btn btn-sm dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <img src="{{ asset('assets/flag/usa.png' . $currentLocale . '.png') }}"
                alt="{{ $availableLocales[$currentLocale] }}" width="20" height="15" class="mr-1">
            {{ strtoupper($currentLocale) }}
        </button>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
            @foreach($availableLocales as $locale => $language)
                @if($locale !== $currentLocale)
                    <a class="dropdown-item" href="#" wire:click.prevent="switchLanguage('{{ $locale }}')">
                        <img src="{{ asset('assets/flag/kh.png' . $locale . '.png') }}" alt="{{ $language }}" width="20" height="15"
                            class="mr-2">
                        {{ $language }}
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>

@push('styles')
    <style>
        .language-switcher .dropdown-toggle {
            background: transparent;
            border: 1px solid #dee2e6;
            color: inherit;
        }

        .language-switcher .dropdown-toggle:after {
            vertical-align: middle;
        }

        .language-switcher .dropdown-item {
            display: flex;
            align-items: center;
        }

        .language-switcher .dropdown-item img {
            margin-right: 8px;
        }
    </style>
@endpush
