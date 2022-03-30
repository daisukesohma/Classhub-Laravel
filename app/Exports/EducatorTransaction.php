<?php

namespace App\Exports;

use App\Booking;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EducatorTransaction implements FromView, ShouldAutoSize, WithEvents
{

    /**
     * @return View
     */
    public function view(): View
    {
        $lessonIds = Auth::user()->lessons->pluck('id');

        $allBookings = Booking::with(['transactions','lesson'])->whereIn('lesson_id', $lessonIds)
            ->whereMonth('')->get();

        return view('exports.educator-transactions', compact('allBookings'));
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->mergeCells('A1:H1');
            },
        ];
    }
}
