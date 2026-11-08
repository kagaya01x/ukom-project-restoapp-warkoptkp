<?php

namespace App\Exports;

use App\Models\TransactionModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected int $number = 0;
    protected float $grandTotal = 0;
    public function collection(): Collection
    {

        return TransactionModel::query()
            ->whereBetween('datetime', [
                now()->startOfMonth()->toDateString() . ' 00:00:00',
                now()->endOfMonth()->toDateString() . ' 23:59:59',
            ])->whereHas('order', function ($q) {
                $q->where('order_status', 'completed');
            })->get();
    }

    public function headings(): array
    {
        return [
            'No.',
            'Tanggal',
            'ID Transaksi',
            'Kwitansi',
            'Metode Pembayaran',
            'Sub Total Transaksi',
        ];
    }

    public function map($transaction): array
    {
        $this->number++;

        $this->grandTotal += $transaction->grand_total;
        return [
            $this->number,
            $transaction->datetime,
            $transaction->transaction_id,
            $transaction->invoice,
            $transaction->payment_method,
            $transaction->grand_total,    
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $lastRow = $event->sheet->getHighestRow();

                $event->sheet->setCellValue(
                    'E' . ($lastRow + 1),
                    'TOTAL KESELURUHAN'
                );

                $event->sheet->setCellValue(
                    'F' . ($lastRow + 1),
                    $this->grandTotal
                );

                $event->sheet->getStyle(
                    'E' . ($lastRow + 1) . ':F' . ($lastRow + 1)
                )->getFont()->setBold(true);

            },
        ];
    }
}
