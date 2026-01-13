@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>請求書登録</h2>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">一覧へ戻る</a>
    </div>

    <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- 左側: 入力フォーム -->
            <div class="col-md-7 col-12">
                <!-- 種類選択を追加 -->
                <div class="mb-3">
                    <label class="form-label">種類</label>
                    <select name="InvoiceTypeID" class="form-select">
                        <option value="">-- 選択してください --</option>
                        @foreach($invoiceTypes as $type)
                        <option value="{{ $type->InvoiceTypeID }}"
                            @selected(old('InvoiceTypeID')==$type->InvoiceTypeID)>
                            {{ $type->DocumentType }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">請求日</label>
                    <input type="date" name="invoice_date" class="form-control" value="{{ old('invoice_date') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">取引先</label>
                    <input type="text" name="vendor" class="form-control" value="{{ old('vendor') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">金額</label>
                    <input type="number" name="amount" class="form-control" value="{{ old('amount') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">PDFファイル</label>
                    <input type="file" name="pdf" id="pdfInput" class="form-control" accept="application/pdf" required>
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-success" id="submitBtn">保存</button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">一覧へ戻る</a>
                </div>

                <script>
                    document.querySelector('form').addEventListener('submit', function() {
                        const btn = document.getElementById('submitBtn');
                        btn.disabled = true;
                        btn.innerText = '送信中...';
                    });
                </script>
            </div>

            <!-- 右側: プレビュー -->
            <div class="col-md-5 col-12 mt-3 mt-md-0">
                <div id="previewArea" style="display:none;">
                    <label class="form-label">プレビュー</label>
                    <div class="paper-preview">
                        <iframe id="pdfPreview"></iframe>
                    </div>
                </div>

                <style>
                    .paper-preview {
                        aspect-ratio: 210 / 297;
                        /* A4縦比率 */
                        width: 100%;
                        /*max-width: 400px;*/
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        background: #fdfdfd;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
                        padding: 8px;
                    }

                    .paper-preview iframe {
                        width: 100%;
                        height: 100%;
                        border: none;
                        background: transparent;
                    }
                </style>
            </div>
        </div>
    </form>
</div>
<script>
    document.getElementById('pdfInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type === "application/pdf") {
            const fileURL = URL.createObjectURL(file);
            document.getElementById('pdfPreview').src = fileURL;
            document.getElementById('previewArea').style.display = 'block';
        } else {
            document.getElementById('previewArea').style.display = 'none';
        }
    });
</script>
@endsection