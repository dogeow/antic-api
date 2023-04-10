<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Actions\Action;
use Illuminate\Contracts\View\View;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.settings';

    protected static ?string $title = 'Custom Page Title';

    protected static ?string $navigationLabel = 'Custom Navigation Label';

    protected static ?string $slug = 'custom-url-slug';

    protected function getHeader(): View
    {
        return view('filament.settings.custom-header');
    }

    protected function getFooter(): View
    {
        return view('filament.settings.custom-footer');
    }

    protected function getActions(): array
    {
        return [
            Action::make('settings')->action('openSettingsModal'),
        ];
    }

    public function openSettingsModal(): void
    {
        $this->dispatchBrowserEvent('open-settings-modal');
    }
}
