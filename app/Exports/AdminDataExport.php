<?php

namespace App\Exports;

use App\Libraries\AdminExportLibrary;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AdminDataExport implements FromCollection, ShouldAutoSize, WithHeadings, WithTitle
{
    public function __construct(private readonly string $dataset) {}

    /**
     * @return Collection<int, array<int, mixed>>
     */
    public function collection(): Collection
    {
        return app(AdminExportLibrary::class)->rows($this->dataset);
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return app(AdminExportLibrary::class)->headings($this->dataset);
    }

    public function title(): string
    {
        return app(AdminExportLibrary::class)->title($this->dataset);
    }
}
