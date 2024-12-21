<?php

namespace App\Exports\Master\Customer;

use App\Models\Master\MasterCustomer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class MasterCustomerExport extends DefaultValueBinder implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder
{
    protected $filters = [];

    public function __construct(array $filters)
    {
        // Hanya izinkan filter tertentu (email dan status)
        $allowedFilters = ['code_from', 'code_to', 'name', 'status', 'ppn'];
        $this->filters = array_filter(
            $filters,
            fn ($key) => in_array($key, $allowedFilters),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $query = MasterCustomer::query();

        // // Terapkan filter dinamis
        foreach ($this->filters as $key => $value) {
            if ($key === 'name') {
                $query->where('nameCustomer', 'like', "%{$value}%");
            } elseif ($key === 'status') {
                $query->where('status', $value);
            } elseif ($key === 'ppn') {
                $query->where('ppn', $value);
            } elseif ($key === 'code_from') {
                $query->where('codeCustomer', '>=', $value); // Filter untuk batas bawah
            } elseif ($key === 'code_to') {
                $query->where('codeCustomer', '<=', $value); // Filter untuk batas atas
            }
        }
        return $query;
    }
    public function map($customers): array
    {
        return [
            $customers->codeCustomer,
            $customers->nameCustomer,
            $customers->abbreviation,
            $customers->addressLine1,
            $customers->addressLine2,
            $customers->ppn,
            $customers->phone,
            $customers->email,
            $customers->attention,
            $customers->priceType,
            $customers->top,
            $customers->npwp,
            $customers->nik,
            $customers->status,
        ];
    }
    public function bindValue(Cell $cell, $value)
    {
        if (is_string($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'abbreviation',
            'Address 1',
            'Address 2',
            'PPN',
            'Phone',
            'Email',
            'Attention',
            'Price Type',
            'TOP',
            'NPWP',
            'NIK',
            'Status',
        ];
    }
}
