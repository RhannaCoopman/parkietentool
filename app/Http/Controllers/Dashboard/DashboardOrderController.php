<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Order;
use App\Models\Orders_item;
use App\Models\Ring;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Dompdf\Dompdf;
use Dompdf\Options;

class DashboardOrderController extends Controller
{
  private $order;

  public function __construct(Order $order)
  {
    $this->order = $order;
  }


  public function orders(Request $request)
  {
    $query = $this->order->query()
      ->orderBy('created_at', 'DESC')
      ->join('users', 'orders.user_id', '=', 'users.id')
      ->select('orders.*', 'users.firstname as firstname', 'users.lastname as lastname');

    $this->applyFilters($request, $query);

    // Check if the export button was clicked
    if ($request->has('export')) {
      return $this->export($request);
    }

    $orders = $query->simplePaginate(20);
    $order_items = Orders_item::all();

    return view('dashboard.orders.orders', compact('orders', 'order_items'));
  }

  public function editOrder(Order $order)
  {
    // $orders = Order::all();
    // $order_items = Orders_item::all();
    $order_items = Orders_item::where('order_id', $order->id)->get();
    $rings = Ring::join('types', 'rings.type_id', '=', 'types.id')
      ->select('rings.*', 'types.name as type_name')
      ->get();

    return view('dashboard.orders.edit', compact('order', 'order_items', 'rings'));
  }

  public function showOrder(Order $order)
  {
    // $orders = Order::all();
    $user_info = User::where('id', $order->user_id)->first();

    $order_items = Orders_item::where('order_id', $order->id)->get();

    $ordered_amount_rings = Orders_item::where('order_id', $order->id)->groupBy('order_id')->sum('amount');

    return view('dashboard.orders.detail', compact('order', 'order_items', 'user_info', 'ordered_amount_rings'));
  }

  public function updateOrder(Order $order, PostRequest $r)
  {
    $r->validate([
      'shipping_data' => ['string', 'max:255'],
      'payment_data' => ['string', 'max:255'],
      'admin_remarks' => ['string', 'max:255'],
  ]);

    $order->shipping_data = $r->shipping_data;
    $order->payment_data = $r->payment_data;
    $order->status = $r->status;
    $order->admin_remarks = $r->admin_remarks;

    $order->updated_at = date("Y-M-d h:m:s");

    $order->save();

    return redirect()->route('dashboard.orders.detail', $order->id);
  }

  private function applyFilters(Request $request, $query)
  {
    if ($request->filled('id')) {
      $query->where('orders.id', $request->input('id'));
    }

    if ($request->filled('name')) {
      $name = $request->input('name');
      $query->where(function ($query) use ($name) {
        $query->where('users.firstname', 'LIKE', "%$name%")
          ->orWhere('users.lastname', 'LIKE', "%$name%");
      });
    }

    if ($request->filled('status')) {
      $query->where('orders.status', $request->input('status'));
    }

    if ($request->filled('created_at')) {
      $created_at = $request->input('created_at');
      if ($created_at === 'this_month') {
        $query->whereMonth('orders.created_at', now()->month)
          ->whereYear('orders.created_at', now()->year);
      } else {
        $query->whereMonth('orders.created_at', substr($created_at, 5))
          ->whereYear('orders.created_at', substr($created_at, 0, 4));
      }
    }
  }

  public function exportExcel(Request $request)
  {
    // Retrieve the checked order IDs from the request
    $checkedOrderIds = $request->selected_orders;

    // Fetch the orders based on the IDs
    $order_items = Orders_item::where('order_id', $checkedOrderIds)->join('rings', 'orders_items.ring_id', '=', 'rings.id')->join('types', 'rings.type_id', '=', 'types.id')->select('orders_items.*', 'rings.size as size', 'types.name as typename')->get();

    // Retrieve name for excelfile from request
    $excelname = $request->excel_name;

    // Create a new Spreadsheet instance
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set the headers
    $sheet->setCellValue('A1', 'Order ID');
    $sheet->setCellValue('B1', 'Club');
    $sheet->setCellValue('C1', 'Ring diameter');
    $sheet->setCellValue('D1', 'Ring materiaal');
    $sheet->setCellValue('E1', 'Aantal');
    $sheet->setCellValue('F1', 'Eerste nummer');
    $sheet->setCellValue('G1', 'Laatste nummer');


    // Populate the data rows
    $row = 2;
    foreach ($order_items as $order_item) {
      $sheet->setCellValue('A' . $row, $order_item->order_id);
      $sheet->setCellValue('B' . $row, "ABAP");
      $sheet->setCellValue('C' . $row, $order_item->size);
      $sheet->setCellValue('D' . $row, $order_item->typename);
      $sheet->setCellValue('E' . $row, $order_item->amount);
      $sheet->setCellValue('F' . $row, $order_item->first_ring_number);      
      $sheet->setCellValue('G' . $row, $order_item->last_ring_number);

      $row++;
    }

    // Save the spreadsheet to a file
    $writer = new Xlsx($spreadsheet);
    $writer->save('/Users/rhanna/Documents/School 2022-2023/Webdev 2/Eindopdracht-Parkietringen/public/Excels/' . $excelname . '.xlsx');

    // Redirect back or perform any other action
    return redirect()->back()->with('success', 'De geselecteerde bestellingen zijn succesvol geëxporteerd! Je vindt ze in de map public in de map Excels.');
  }


  public function exportPdf($orderId)
  {
    // Retrieve the order, user info, and order items
    $order = Order::findOrFail($orderId);
    $user_info = User::where('id', $order->user_id)->first();
    $order_items = Orders_item::where('order_id', $order->id)->join('rings', 'orders_items.ring_id', '=', 'rings.id')->join('types', 'rings.type_id', '=', 'types.id')->select('orders_items.*', 'rings.size as size', 'types.name as typename')->get();

    // Set up Dompdf options
    $options = new Options();
    $options->set('defaultFont', 'Arial');

    // Create a new Dompdf instance
    $dompdf = new Dompdf($options);

    // Load the PDF view
    $pdfView = view('dashboard.orders.export-pdf', compact('order', 'user_info', 'order_items'));

    // Render the PDF
    $dompdf->loadHtml($pdfView->render());
    $dompdf->render();

    // Generate a filename for the PDF
    $filename = 'order_' . $order->id . '.pdf';

    // Save the PDF file to the specified directory
    $dompdf->stream($filename, [
      'Attachment' => false,
      'compress' => 1,
      'Content-Disposition' => 'attachment; filename="' . $filename . '"',
      'save_directory' => '/Users/rhanna/Documents/School 2022-2023/Webdev 2/Eindopdracht-Parkietringen/public/Eigendomsbewijzen/'
    ]);

    // Redirect back or perform any other action
    return redirect()->back()->with('success', 'De eigendomsbewijzen zijn gemaakt. Je vindt ze in de map Public in de map eigendomsbewijzen.');
  }
}
