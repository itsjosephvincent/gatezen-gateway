<x-mail::message>
Dear {{ $document->kyc_application->user->firstname }},

We hope this message finds you well.

We regret to inform you that the document submitted on {{ $document->created_at }} for our verification process did not meet our requirements due to the following reason(s):

**{{ $document->external_note }}**

We kindly request your assistance in re-submitting a document that fulfills our verification criteria. Your cooperation in this matter is greatly appreciated.

Thank you for choosing our services. Should you have any queries or require further assistance, please do not hesitate to contact us.
</x-mail::message>
