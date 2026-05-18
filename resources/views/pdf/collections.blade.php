<!doctype html>
<html><body style="font-family: DejaVu Sans, sans-serif;">
    <h1>Collection Report</h1>
    <table width="100%" cellspacing="0" cellpadding="6" border="1">
        <thead><tr><th>Reference</th><th>Client</th><th>Amount</th><th>Date</th></tr></thead>
        <tbody>
        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->reference_number }}</td>
                <td>{{ $payment->client?->full_name }}</td>
                <td>PHP {{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->paid_at?->format('M d, Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body></html>
