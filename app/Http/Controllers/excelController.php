<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DB;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\TcpdfFpdi;
use TCPDF_FONTS;

class excelController extends Controller
{
    //
    public function excel_export(Request $request)
    {

        $articles = DB::table('stamp')->get()->toArray();

        // Load the Excel file
        $filePath = (storage_path('app/public/xlsx/template.xlsx'));
        $spreadsheet = IOFactory::load($filePath);

        // Select the active sheet
        $sheet = $spreadsheet->getSheet(0);
        $cnt = 2;

        foreach($articles as $article){
            $day_datein = new DateTime($article->punch_in);
            $day_dateout = new DateTime($article->punch_out);
            $time_in = $day_datein->format('H:i');
            $time_out = $day_dateout->format('H:i');
            $day = $day_datein->format('Y/m/d');
            $date = $day_datein->format('Y年m月');

            if($date == $_POST['date']){
                $sheet->setCellValue('A'.$cnt, $article->user_id);
                $sheet->setCellValue('B'.$cnt, $article->user_name);
                $staff = DB::table('users')->find($article->user_id);
                $sheet->setCellValue('C'.$cnt, $staff->stafftype);
                $sheet->setCellValue('D'.$cnt, $day);
                $sheet->setCellValue('E'.$cnt, $time_in);
                $sheet->setCellValue('F'.$cnt, $time_out);

                $cnt = $cnt + 1;
            }
        }

        $today = date("YmdHis");
        // Save the changes
        $after_filePath = (storage_path('app/public/xlsx/' . $today . '.xlsx'));
        $writer = new Xlsx($spreadsheet);
        $writer->save($after_filePath);

        return response()->download($after_filePath)->deleteFileAfterSend(true);
    }
}
