<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $project->order_id }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10pt; color: #374151; line-height: 1.4; padding: 40px; }
        
        .header { overflow: hidden; margin-bottom: 40px; }
        .logo { float: left; font-size: 22pt; font-weight: bold; color: #111; margin: 0; }
        .logo span { color: #2563eb; }
        .invoice-title { float: right; font-size: 28pt; font-weight: bold; color: #e5e7eb; letter-spacing: 2px; text-transform: uppercase; line-height: 1; }
        
        .meta-box { clear: both; margin-bottom: 30px; display: table; width: 100%; border-top: 1px solid #111; padding-top: 20px; }
        .meta-col { display: table-cell; vertical-align: top; width: 33%; }
        
        h3 { font-size: 9pt; color: #6b7280; text-transform: uppercase; margin: 0 0 5px 0; font-weight: bold; }
        p { margin: 0 0 10px 0; font-size: 11pt; font-weight: bold; color: #111; }
        .sub-text { font-size: 9pt; color: #4b5563; font-weight: normal; line-height: 1.4; }
        
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table.items th { text-align: left; background: #f9fafb; padding: 12px 10px; font-weight: bold; color: #374151; border-bottom: 2px solid #e5e7eb; font-size: 9pt; text-transform: uppercase; }
        table.items td { padding: 15px 10px; border-bottom: 1px solid #f3f4f6; }
        
        .total-section { float: right; width: 300px; text-align: right; }
        .total-row { padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-size: 10pt; }
        .total-row.final { font-size: 14pt; font-weight: bold; color: #2563eb; border-bottom: none; border-top: 2px solid #e5e7eb; margin-top: 10px; padding-top: 15px; }
        
        .payment-info { float: left; width: 50%; margin-top: 20px; background: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; }
        .payment-title { font-weight: bold; font-size: 10pt; margin-bottom: 10px; color: #111; }
        
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 8pt; color: #9ca3af; margin-top: 50px; }
        
        .watermark { position: absolute; top: 40%; left: 30%; transform: rotate(-30deg); font-size: 100px; font-weight: bold; color: rgba(37, 99, 235, 0.05); border: 5px solid rgba(37, 99, 235, 0.05); padding: 20px 50px; border-radius: 20px; z-index: -1; }
    </style>
</head>
<body>
    <div class="watermark">PAID</div>

    <div class="header">
        <h1 class="logo">DjokiHub<span>.</span></h1>
        <div class="invoice-title">INVOICE</div>
    </div>

    <div class="meta-box">
        <div class="meta-col">
            <h3>Bill To</h3>
            <p>{{ $project->client_name ?? 'Valued Client' }}</p>
            <div class="sub-text">Project Owner</div>
        </div>
        <div class="meta-col">
            <h3>Invoice Details</h3>
            <div class="sub-text">
                Number: <strong>#{{ $project->order_id }}</strong><br>
                Date: {{ now()->format('d M Y') }}<br>
                Due Date: {{ now()->format('d M Y') }} (Immediate)
            </div>
        </div>
        <div class="meta-col" style="text-align: right;">
            <h3>Project</h3>
            <p>{{ $project->name ?? 'Project Name' }}</p>
        </div>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th width="50%">Description</th>
                <th width="15%" style="text-align: right;">Rate</th>
                <th width="10%" style="text-align: center;">Qty</th>
                <th width="25%" style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <b>Software Development Services</b><br>
                    <span style="font-size: 9pt; color: #666;">Full Cycle Development for {{ $project->name }}</span>
                </td>
                <td style="text-align: right;">Rp {{ number_format($project->budget, 0, ',', '.') }}</td>
                <td style="text-align: center;">1</td>
                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($project->budget, 0, ',', '.') }}</td>
            </tr>
             @if($project->deliverables->count() > 0)
            <tr>
                <td colspan="4" style="padding-top: 5px; padding-bottom: 5px; font-size: 9pt; color: #666; font-style: italic;">
                    <strong>Included Deliverables:</strong> {{ $project->deliverables->implode('name', ', ') }}
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="payment-info">
        <div class="payment-title">Payment Method (QRIS)</div>
        <div style="text-align: center; margin: 15px 0;">
            <img src="{{ public_path('images/qris.png') }}" style="width: 180px; height: auto; display: block; margin: 0 auto;">
            <p style="margin-top: 10px; font-size: 9pt; font-weight: bold;">NAMA MERCHANT: DJOKI CODING</p>
        </div>
        <div class="sub-text" style="text-align: center;">
            Scan using GoPay, OVO, Dana, LinkAja, or Mobile Banking.
        </div>
    </div>

    <div class="total-section">
        <div class="total-row">
            Subtotal: <span>Rp {{ number_format($project->budget, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            Tax (0%): <span>Rp 0</span>
        </div>
        <div class="total-row final">
            TOTAL: Rp {{ number_format($project->budget, 0, ',', '.') }}
        </div>
    </div>

    <div style="clear: both; margin-top: 80px;">
        <p style="text-align: center; font-size: 10pt; color: #111;">Terms & Conditions</p>
        <p style="text-align: center; font-size: 8pt; color: #666; font-weight: normal;">
            Payment is due upon receipt. Please notify us of any discrepancies within 3 business days.<br>
            Thank you for your business!
        </p>
    </div>

    <div class="footer">
        DjokiHub &bull; Software Development Services &bull; www.djokihub.com
    </div>
</body>
</html>
