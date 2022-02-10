<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $invoices = Invoice::latest()->when(
            request()->q,
            function ($invoices) {
                $invoices = $invoices->where('invoice', 'like', '%' .
                    request()->q . '%');
            }
        )->paginate(10);
        return view('admin.order.index', compact('invoices'));
    }

    /**
     * show
     *
     * @param mixed $invoice
     * @return void
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('admin.order.show', compact('invoice'));
    }

    /**
     * RESI PENGIRIMAN
     * 
     * @param  mixed $request
     * @param  mixed $$invoice
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'shipping_receipt'  => 'required|max:30'
        ]);

        // //update data resi
        $invoice = Invoice::whereId($id);
        $invoice->update([
            'shipping_receipt' => $request->shipping_receipt,
        ]);

        if ($invoice) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.order.index')->with(['success' => 'Data Berhasil Diperbarui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.order.index')->with(['error' => 'Data Gagal Diperbarui!']);
        }
    }
}
