<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Mail;

class MailSheet implements FromQuery, WithTitle, ShouldAutoSize, WithHeadings
{

    public function headings(): array
    {
        return [
            'Почта'
        ];
    }

    public function query()
    {
        return Mail::select('mails.title');
    }

    public function title(): string
    {
        return 'Почты';
    }
}
