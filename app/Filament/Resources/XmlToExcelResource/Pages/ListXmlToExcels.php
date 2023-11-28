<?php

namespace App\Filament\Resources\XmlToExcelResource\Pages;

use App\Filament\Resources\XmlToExcelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Redirect;

class ListXmlToExcels extends ListRecords
{
    protected static string $resource = XmlToExcelResource::class;

    public function mount(): void
    {
        $this->redirectCustom();
    }

    public function redirectCustom()
    {
        return redirect()->route('filament.dashboard.resources.xml-to-excels.create');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
