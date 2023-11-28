<?php

namespace App\Filament\Resources\XmlToExcelResource\Pages;

use App\Filament\Resources\XmlToExcelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditXmlToExcel extends EditRecord
{
    protected static string $resource = XmlToExcelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
