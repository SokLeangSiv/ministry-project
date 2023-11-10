<?php
namespace App\Exports;
use App\Models\TblCase;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class CaseExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnWidths,
    WithEvents
{
    public function headings(): array
    {

        return [
            'កាលបរិច្ឆេទទទួលបណ្តឹង',
            'លេខបណ្តឹង',
            'ប្រភេទ',
            'លេខទូរស័ព្ទ',
            'ស្ថានភាព',
            'ចំណាត់ការ',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 35,
        ];
    }

    public function query()
    {
        $departmentId = Auth::user()->department;
        $status = request()->input('status');
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');

        $query = TblCase::query()
            ->where('department', $departmentId)
            ->select('sent_date', 'case_number', 'is_new', 'complainer_tele', 'status', 'department');

        if ($status != null) {
            $query = $query->where('status', $status);
        }

        if (($start_date != null) && ($end_date != null)) {
            $query = $query->whereBetween('sent_date', [$start_date, $end_date]);
        }

        return $query;
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:F1'; // All headers
                $styleArray = [
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'FF7F50', // Set your color here
                        ],

                    ],
                ];

                // $cellRange = 'A2:E1000'; // All data
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $event->sheet->getStyle($cellRange)->applyFromArray($styleArray);
            },
        ];
    }


    public function map($case): array
    {
        $status_string = "";
        $status_department="";


    switch ($case->status) {
        case 1:
            $status_string = "បានទទួល";
            break;
        case 2:
            $status_string = "កំពុងដោះស្រាយ";
            break;
        case 3:
            $status_string = "ដោះស្រាយរួចរាល់";
            break;
        default:
            $status_string = "បោះបង់";
    }
    
    switch ($case->department) {
        case 1:
            $status_department = "អគ្គនាយកដ្ឋានគយនិងរដ្ឋាករកម្ពុជា";
            break;
        case 2:
            $status_department = "អគ្គស្នងការដ្ឋាននគរបាលជាតិ";
            break;
        case 3:
            $status_department = "អគ្គនាយកដ្ឋាន អន្តោប្រវេសន៍";
            break;
        case 4:
            $status_department = "អភិបាលរាជធានី-ខេត្ត";
            break;
        default:
            $status_department = "ដំណាងក្រសួងការងារ";
    }
    return [
        $case->sent_date,
        $case->case_number,
        $case->is_new == 1 ? "ថ្មី" : "ចាស់",
        $case->complainer_tele,
        $status_string,
        $status_department,
    ];
}
public function styles(Worksheet $sheet)
{
    return [
        // Style the entire sheet
        1 => ['font' => ['name' => 'Siemreap']],
    ];
}

}
