<?php

namespace App\Filament\Resources\XmlToExcelResource\Pages;

use Filament\Actions;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;
use App\Exports\CfdisExport;
use Filament\Actions\Action;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use PHPUnit\TestRunner\TestResult\Collector;
use App\Filament\Resources\XmlToExcelResource;

class CreateXmlToExcel extends CreateRecord
{
    protected static string $resource = XmlToExcelResource::class;

    protected function getCreateAnotherFormAction(): Action
    {
        $file = storage_path() . '/app/cfdis.xlsx';
        if (file_exists($file)) {
            return Action::make(__('Descargar excel'))
                ->url(route('download'))
                ->color('success');
        }

        return Action::make(__('Descargar excel'))
            ->url(route('download'))
            ->hidden();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $this->exportExcel($data);

        $record = static::getModel()::create();

        return $record;
    }

    public function exportExcel(array $data)
    {
        $path = storage_path() . '/app/cfdis.xlsx';

        if (file_exists($path)) {
            File::delete($path);
        }

        if (!empty($data['attachments'])) {
            $cfdis = collect();

            foreach($data['attachments'] as $xml) {
                $cfdi = \CfdiUtils\Cfdi::newFromString($xml->get());
                $cfdis->push($cfdi);
            }

            $export = new CfdisExport($cfdis);

            Excel::store($export, 'cfdis.xlsx');
        }
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')->hidden();
    }

    public function getTitle(): string | Htmlable
    {
        if (filled(static::$title)) {
            return static::$title;
        }

        return Str::headline(static::getResource()::getModelLabel());
    }
}
