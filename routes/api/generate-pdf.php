<?php

use App\Exports\Master\Customer\MasterCustomerExport;
use App\Http\Controllers\API\V1\Master\General\MasterCustomerController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;


Route::prefix('V1')->group(function () {
    Route::get('master-customer/generate-pdf/', [MasterCustomerController::class, 'generatePDF'])
        ->name('generate-pdf.customer');
});
