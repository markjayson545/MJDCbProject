<?php

namespace App\Http\Controllers\Administrator;

use App\Exports\AdminDataExport;
use App\Http\Controllers\Archived\Controller;
use App\Libraries\AdminExportLibrary;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends Controller
{
    public function pdf(string $dataset, AdminExportLibrary $exports): Response
    {
        abort_unless($exports->isSupported($dataset), 404);

        $pdf = Pdf::loadView('admin.exports.report', $exports->viewData($dataset))
            ->setPaper('a4', 'landscape');

        return $pdf->download($exports->filename($dataset, 'pdf'));
    }

    public function excel(string $dataset, AdminExportLibrary $exports): BinaryFileResponse
    {
        abort_unless($exports->isSupported($dataset), 404);

        return Excel::download(new AdminDataExport($dataset), $exports->filename($dataset, 'xlsx'));
    }
}
