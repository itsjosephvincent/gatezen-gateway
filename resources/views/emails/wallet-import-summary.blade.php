<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet Import Summary</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0;">

    <div style="background-color: #f5f5f5; padding: 20px;">
        <p style="font-size: 18px; color: #333; margin-bottom: 20px;">Dear {{ $user->firstname ?? 'User' }},</p>
        <p style="font-size: 16px; color: #666; margin-bottom: 30px;">
            We're pleased to provide you with a comprehensive summary of the ongoing wallet import process initiated by you. Below, you'll find important details regarding the import status and outcomes.
        </p>

    </div>

    <div style="margin: 20px 0;">
        <p>Successful transactions:<br></p>
        <table style="border-collapse: collapse; width: 100%; font-size: 14px;">
            <thead style="background-color: #f7f7f7;">
                <tr>
                    <th style="padding: 10px; border: 1px solid #ddd;">Type</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Email</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Description</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Amount</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Shares</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Price</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($successfulTransactions as $success)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $success['data']['type'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $success['data']['email'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $success['data']['description'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $success['data']['amount'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $success['data']['shares'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $success['data']['price'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $success['data']['date'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin: 20px 0;">
        <p>Unsuccessful transactions:<br></p>
        <table style="border-collapse: collapse; width: 100%; font-size: 14px;">
            <thead style="background-color: #f7f7f7;">
                <tr>
                    <th style="padding: 10px; border: 1px solid #ddd;">Type</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Email</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Description</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Amount</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Shares</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Price</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Date</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($failedTransactions as $failed)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $failed['data']['type'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $failed['data']['email'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $failed['data']['description'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $failed['data']['amount'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $failed['data']['shares'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $failed['data']['price'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $failed['data']['date'] }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $failed['error'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
