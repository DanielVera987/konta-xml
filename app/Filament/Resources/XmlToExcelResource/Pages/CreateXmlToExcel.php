<?php

namespace App\Filament\Resources\XmlToExcelResource\Pages;

use Filament\Actions;
use App\Exports\CfdisExport;
use Filament\Actions\Action;
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
        $path = storage_path().'/'.'app/cfdis.xlsx';
        if (file_exists($path)) {
            return Action::make('Descargar excel')
                ->url(route('download'))
                ->color('success');
        }

        return Action::make(null);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $this->ExportExcel($data);

        $record = static::getModel()::create();

        return $record;
    }

    public function ExportExcel(array $data)
    {
        $path = storage_path().'/'.'app/cfdis.xlsx';
        if (file_exists($path)) {
            \File::delete($path);
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
}
