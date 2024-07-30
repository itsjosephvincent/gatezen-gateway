<x-mail::message>
Dear {{ $invoice->customer->firstname }},

A payment document {{ $invoice->invoice_number }} has been created for your account and is due on {{ \Carbon\Carbon::parse($invoice->due_date)->format('d.m.Y') }}.

Kindly see the attached payment document.

Thank you for your business.
</x-mail::message>
