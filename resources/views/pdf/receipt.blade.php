<!doctype html>
<html><body style="font-family: DejaVu Sans, sans-serif;">
    <h1>Official Receipt</h1>
    <p><strong>Reference:</strong> {{ $payment->reference_number }}</p>
    <p><strong>Client:</strong> {{ $payment->client?->full_name }}</p>
    <p><strong>Billing:</strong> {{ $payment->billing?->billing_number }}</p>
    <p><strong>Amount:</strong> PHP {{ number_format($payment->amount, 2) }}</p>
    <p><strong>Date:</strong> {{ $payment->paid_at?->format('M d, Y h:i A') }}</p>
    <p><strong>Collected by:</strong> {{ $payment->collector?->name }}</p>
</body></html>
