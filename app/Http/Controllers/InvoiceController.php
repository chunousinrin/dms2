<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceType;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class InvoiceController extends Controller
{
    // 一覧表示
    public function index(Request $request)
    {
        $query = Invoice::with('invoiceType');

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('extracted_text', 'like', "%{$keyword}%")
                    ->orWhere('vendor', 'like', "%{$keyword}%");
            });
        }

        // 期間検索
        if ($request->filled('start_date')) {
            $query->whereDate('invoice_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('invoice_date', '<=', $request->end_date);
        }

        // 種類フィルタ
        if ($request->filled('InvoiceTypeID')) {
            $query->where('InvoiceTypeID', $request->InvoiceTypeID);
        }

        $invoices = $query->orderBy('invoice_date', 'desc')->paginate(25);
        $invoiceTypes = InvoiceType::orderBy('DocumentType')->get();

        return view('invoices.index', compact('invoices', 'invoiceTypes'));
    }

    // 登録フォーム
    public function create()
    {
        $invoiceTypes = InvoiceType::orderBy('DocumentType')->get();
        return view('invoices.create', compact('invoiceTypes'));
    }

    // 保存処理
    public function store(Request $request)
    {
        $request->validate([
            'vendor' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'amount' => 'required|numeric',
            'pdf' => 'required|mimes:pdf|max:4096',
            'InvoiceTypeID' => 'nullable|exists:invoice_type,InvoiceTypeID',
        ]);

        $path = $request->file('pdf')->store('invoices');

        $invoice = Invoice::create([
            'vendor' => $request->vendor,
            'invoice_date' => $request->invoice_date,
            'amount' => $request->amount,
            'file_path' => $path,
            'InvoiceTypeID' => $request->InvoiceTypeID,
        ]);

        // OCR処理
        $text = Pdf::getText(
            Storage::path($invoice->file_path),
            'D:\\laragon-6.0.0\\laragon-6.0.0\\bin\\poppler\\Library\\bin\\pdftotext.exe'
        );
        $invoice->update(['extracted_text' => $text]);

        return redirect()->route('invoices.index')->with('success', '請求書を登録しました');
    }

    // PDFプレビュー
    public function showPdf(Invoice $invoice)
    {
        $path = Storage::path($invoice->file_path);
        return response()->file($path);
    }
}
