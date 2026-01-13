@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>請求書一覧</h2>
        <a href="{{ route('invoices.create') }}" class="btn btn-secondary">新規登録</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('invoices.index') }}" class="mb-3">
        @php
        $hasFilter = request()->filled('start_date') || request()->filled('end_date') || request()->filled('keyword');
        @endphp

        <div class="accordion mb-3" id="searchAccordion">
            <div class="accordion-item border-success">
                <h2 class="accordion-header" id="headingSearch">
                    <button class="accordion-button {{ $hasFilter ? '' : 'collapsed' }} bg-success text-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseSearch"
                        aria-expanded="{{ $hasFilter ? 'true' : 'false' }}" aria-controls="collapseSearch">
                        検索条件
                    </button>
                </h2>
                <div id="collapseSearch"
                    class="accordion-collapse collapse {{ $hasFilter ? 'show' : '' }}"
                    aria-labelledby="headingSearch" data-bs-parent="#searchAccordion">
                    <div class="accordion-body bg-light">
                        <form method="GET" action="{{ route('invoices.index') }}">
                            <div class="col-md-3">
                                <label for="InvoiceTypeID" class="form-label">種類</label>
                                <select id="InvoiceTypeID" name="InvoiceTypeID" class="form-select">
                                    <option value="">-- 全て --</option>
                                    @foreach($invoiceTypes as $type)
                                    <option value="{{ $type->InvoiceTypeID }}"
                                        {{ request('InvoiceTypeID') == $type->InvoiceTypeID ? 'selected' : '' }}>
                                        {{ $type->DocumentType }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="row g-3">
                                <!-- 開始日 -->
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">開始日</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>

                                <!-- 終了日 -->
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">終了日</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>

                                <!-- キーワード -->
                                <div class="col-md-6">
                                    <label for="keyword" class="form-label">検索キーワード</label>
                                    <input type="text" id="keyword" name="keyword" class="form-control"
                                        placeholder="取引先名 / OCRテキスト" value="{{ request('keyword') }}">
                                </div>
                            </div>

                            <!-- ボタンを下側に配置 -->
                            <div class="mt-3 d-flex justify-content-end">
                                <button class="btn btn-success me-2" style="min-width:120px;" type="submit">検索</button>
                                <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary" style="min-width:120px;">リセット</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>種類</th>
                <th>取引先</th>
                <th>請求日</th>
                <th class="text-end">金額</th>
                <th class="text-center">PDF</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>
                    @if($invoice->invoiceType)
                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                        {{ $invoice->invoiceType->DocumentType }}
                    </span>
                    @else
                    <span class="text-muted">未設定</span>
                    @endif
                </td>
                <td>{{ $invoice->vendor }}</td>
                <td>{{ $invoice->invoice_date }}</td>
                <td class="text-end">{{ number_format($invoice->amount) }} 円</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#pdfModal{{ $invoice->id }}">
                        プレビュー
                    </button>
                </td>
            </tr>
            <!-- モーダル -->
            <div class="modal fade" id="pdfModal{{ $invoice->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">請求書プレビュー</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">

                            <!-- タブ切り替え -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#pdf{{ $invoice->id }}">PDF</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#text{{ $invoice->id }}">OCRテキスト</a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3">
                                <!-- PDF表示 -->
                                <div class="tab-pane fade show active" id="pdf{{ $invoice->id }}">
                                    <iframe src="{{ url('pdfjs/web/viewer.html') }}?file={{ urlencode(route('invoices.showPdf', $invoice->id)) }}"
                                        style="width:100%; height:70vh; border:none;"></iframe>
                                </div>

                                <!-- OCRテキスト表示 -->
                                <div class="tab-pane fade" id="text{{ $invoice->id }}">
                                    <pre style="background:#f8f9fa; padding:10px; white-space:pre-wrap;">
                                    {{ $invoice->extracted_text }}
                                    </pre>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
    <!-- ページネーション -->
    <div class="mt-3">
        {{ $invoices->links() }}
    </div>

</div>
@endsection