<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;

class CfdisExport implements FromView
{
    private $cfdis;

    public function __construct($cfdis)
    {
        $this->cfdis = $cfdis;
    }

    public function view(): View
    {
        return view('cfdisExport', [
            'cfdis' => $this->cfdis
        ]);
    }
}
