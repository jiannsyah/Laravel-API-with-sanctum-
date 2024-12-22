<?php

namespace App\Exports\Master\Customer;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class MasterCustomerExport extends DefaultValueBinder implements FromCollection, WithMapping, WithHeadings, WithCustomValueBinder
{
    use Exportable;

    protected $customers;

    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->customers;
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
