<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportTransactions()
    {
        $startOfTheMonth = now()->startOfMonth()->toDateString();
        $endOfTheMonth = now()->endOfMonth()->toDateString();
        return Excel::download(
            new TransactionsExport,
            'rekapitulasi_bulanan_' . $startOfTheMonth . '_sampai_' . $endOfTheMonth . '.xlsx'
        );
    }
}
