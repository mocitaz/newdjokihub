@extends('emails.layout')

@section('content')
    <div style="text-align: center;">
        <h1>Mission Accomplished 🏆</h1>
        <p>Outstanding work! This project has been marked as fully completed by the administration.</p>
    </div>

    <div class="info-box" style="background: #f0fdf4; border-color: #bbf7d0;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px dashed #bbf7d0; width: 40%; vertical-align: top;">
                    <span class="info-label" style="color: #166534;">Project Completed</span>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px dashed #bbf7d0; width: 60%; text-align: right; vertical-align: top;">
                    <span class="info-value" style="color: #14532d;">{{ $project->name }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; vertical-align: top;">
                    <span class="info-label" style="color: #166534;">Payout Triggered</span>
                </td>
                <td style="padding: 10px 0; text-align: right; vertical-align: top;">
                    <span class="info-value" style="color: #15803d; font-size: 18px;">Rp {{ number_format($project->nett_budget, 0, ',', '.') }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="highlight-text" style="background-color: #fff; border-left: 4px solid #22c55e;">
        <strong>💰 Payment Information:</strong><br>
        Process pencairan dana sedang berjalan dan akan masuk ke rekening terdaftar Anda dalam waktu <strong>1x24 Jam</strong>.
    </div>

    <div style="text-align: center;">
        <a href="{{ route('profile.show') }}" class="btn" style="background: #ffffff; color: #0f172a !important; border: 1px solid #e2e8f0; box-shadow: none;">Verify Banking Details</a>
    </div>
@endsection
