<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $title      = "Daftar Pelanggan Web2Print";
        $date1      = $request->date1 ?? Carbon::now()->startOfMonth()->toDate();
        $date2      = $request->date2 ?? Carbon::now()->toDate();
        $condition  = fn ($query) => $query->where('payment_status', 'Paid');
        // $customers  = Customer::withCount(['order' => $condition])->withSum(['order' => $condition], 'total')->whereBetween('created_at', [$date1, $date2])->latest()->get();
        $customers  = Customer::withCount(['order' => $condition])->withSum(['order' => $condition], 'total')->get();
        return view('customer.index_customer', compact('title', 'customers'));
    }

    public function detail($id)
    {
        $title      = Customer::where('id_customer', $id)->value('name');
        $orders     = Order::where(['payment_status' => 'Paid', 'cust_id' => $id])->get();
        $total      = Order::where(['payment_status' => 'Paid', 'cust_id' => $id])->sum('total');

        return view('customer.detail_belanja', compact('title', 'orders', 'total'));
    }

    public function changePassword(Request $request)
    {
        Customer::where('id_customer', $request->id_customer)->update([
            'password'  => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diganti');
    }

    public function exportExcel()
    {
        $customers      = $this->m_cust->orderBy('created_at desc')->findALl();
        $spreadsheet    = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('Create by SD2 Dev')
            ->setLastModifiedBy('Modified by SD2 Dev');
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getColumnDimension('A')->setWidth(6);
        $worksheet->getColumnDimension('B')->setWidth(35);
        $worksheet->getColumnDimension('C')->setWidth(20);
        $worksheet->getColumnDimension('D')->setWidth(20);
        $worksheet->getColumnDimension('E')->setWidth(20);
        $worksheet->getColumnDimension('F')->setWidth(20);
        $worksheet->getColumnDimension('G')->setWidth(10);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No.')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'No. Telp.')
            ->setCellValue('D1', 'Email')
            ->setCellValue('E1', 'Bergabung sejak')
            ->setCellValue('F1', 'Total belanja')
            ->setCellValue('G1', 'Total order');

        $column = 2;

        foreach ($customers as $id => $cust) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $id + 1)
                ->setCellValue('B' . $column, $cust['name'])
                ->setCellValue('C' . $column, $cust['phone'])
                ->setCellValue('D' . $column, $cust['email'])
                ->setCellValue('E' . $column, $this->myDate($cust['created_at']))
                ->setCellValue('F' . $column, $this->rupiah($this->m_order->totalSale($cust['id_customer'])))
                ->setCellValue('G' . $column, $this->m_order->countOrder($cust['id_customer']));
            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Data-order-' . date('d-m-Y');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$filename.xlsx");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
