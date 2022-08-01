<?php

namespace App\Http\Controllers\Order;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OverdueController extends Controller
{
    public function index()
    {
        abort_if(!in_array(Auth()->user()->role, [1, 5]), 401);

        $title      = "List Overdue GET";
        $orders     = Order::where('status_get', 'Overdue')->latest()->get();

        return view('overdue.index_overdue', compact('title', 'orders'));
    }


    public function invalidOverdue(Request $request)
    {
        Order::where('id_order', $request->id_order)->update(['status_get' => 1]);
        return back();
    }

    public function overdueGet($payment_date, $upload_date, $id_order, $sale_status)
    {
        if ($upload_date) :
            return  $this->calculateOverdueGet($upload_date, $id_order, $sale_status);
        elseif ($payment_date) :
            return  $this->calculateOverdueGet($payment_date, $id_order, $sale_status);
        else :
            return false;
        endif;
    }

    public function calculateOverdueGet($date, $id_order, $status)
    {
        $day    = dayID($date);
        if ($day == "Minggu" || $day == "Sabtu" || $day == "Saturday" || $day == "Sunday") :
            $time_1     = date("Y-m-d 09:00:00", strtotime($date));
            $time_2     = date("Y-m-d 17:45:00", strtotime($date));
        else :
            $time_1     = date("Y-m-d 08:00:00", strtotime($date));
            $time_2     = date("Y-m-d 20:45:00", strtotime($date));
        endif;
        $time_3     = date("Y-m-d 09:00:00", strtotime($date));
        $time_4     = date("Y-m-d 08:00:00", strtotime($date));
        $temp_time  = $date;

        if ($temp_time < $time_1) :
            $temp_time  = $time_1;
        elseif ($temp_time > $time_2) :
            if ($day == "Jumat" || $day == "Sabtu" || $day == "Saturday" || $day == "Friday") :
                $temp_time = date('Y-m-d H:i:s', strtotime(date($time_3) . ' + 1days'));
            else :
                $temp_time = date('Y-m-d H:i:s', strtotime(date($time_4) . ' + 1days'));
            endif;
        else :
            $temp_time = $date;
        endif;
        $max_get = date('Y-m-d H:i:s', strtotime($temp_time) + 60 * 60 * 2);
        $now    = date('Y-m-d H:i:s');
        if ($max_get < $now && $status == "Preparing") :
            // return $this->m_orders->save(['id_order' => $id_order, 'status_get' => 'Overdue']);
            return Order::where('id_order', $id_order)->update(['status_get' => 'Overdue']);
        endif;
        return false;
    }

    public function reportOverdue(Request $request)
    {
        $date1      = $request->date1;
        $date2      = $request->date2;
        $overdue    = Order::where('status_get', 'Overdue')
            ->when($date2, function ($query, $date2) use ($date1) {
                return $query->whereBetween('create_at', [$date1, $date2]);
            })->latest()->get();

        $spreadsheet    = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('Create by SD2 Dev')->setLastModifiedBy('Modified by SD2 Dev');
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getColumnDimension('A')->setWidth(6);
        $worksheet->getColumnDimension('B')->setWidth(20);
        $worksheet->getColumnDimension('C')->setWidth(20);
        $worksheet->getColumnDimension('D')->setWidth(20);
        $worksheet->getColumnDimension('E')->setWidth(30);
        $worksheet->getColumnDimension('F')->setWidth(20);
        $worksheet->getColumnDimension('G')->setWidth(35);
        $worksheet->getColumnDimension('H')->setWidth(35);
        $worksheet->getColumnDimension('I')->setWidth(35);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No.')
            ->setCellValue('B1', 'No. Invoice')
            ->setCellValue('C1', 'Tanggal Order')
            ->setCellValue('D1', 'Tanggal Pembayaran')
            ->setCellValue('E1', 'Tanggal Unggah Bukti TF')
            ->setCellValue('F1', 'Status GET')
            ->setCellValue('G1', 'PIC')
            ->setCellValue('H1', 'Waktu GET')
            ->setCellValue('I1', 'Preparing to Waiting Production');

        $column = 2;
        foreach ($overdue as $id => $report) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $id + 1)
                ->setCellValue('B' . $column, $report->no_inv)
                ->setCellValue('C' . $column, dateTime($report->created_at))
                ->setCellValue('D' . $column, $report->payment_date ? dateTime($report->payment_date) : "Belum tervalidasi automatis")
                ->setCellValue('E' . $column, $report->upload_date ? dateTime($report->upload_date) : "Tidak ada bukti TF")
                ->setCellValue('F' . $column, $report->status_get)
                ->setCellValue('G' . $column, $report->cs)
                ->setCellValue('H' . $column, $report->time_get ? dateTime($report->time_get) : "")
                ->setCellValue('I' . $column, $report->waiting_production ? dateTime($report->waiting_production) : "");
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Report-overdue-get-' . date('d-m-Y');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$filename.xlsx");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
