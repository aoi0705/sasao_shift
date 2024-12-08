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
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $cnt = 2;
        
        // ヘッダーの設定
        $sheet->setCellValue('A1', 'User ID');
        $sheet->setCellValue('B1', 'User Name');
        $sheet->setCellValue('C1', 'Staff Type');
        $sheet->setCellValue('D1', 'Date');
        $sheet->setCellValue('E1', 'Time In');
        $sheet->setCellValue('F1', 'Time Out');

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
        $fileName = $today . '.xlsx';
        $filePath = storage_path('app/public/' . $fileName);

        // Excelファイルの保存
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
