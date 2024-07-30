<style>
    .scrollable-table-container {
        max-height: 400px; /* Set the desired height */
        overflow-y: scroll;
        overflow-x: scroll;
        max-width: 100%;
    }
    .sync-button{
        width: 50%;
    }
    th, td{
        text-align: left;
        padding: 8px;
    }
</style>
<div class="scrollable-table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Role</th>
                @if ($type == \App\Enum\QueryType::Shares->value)
                <th>CWIOP</th>
                <th>CWISC</th>
                <th>Type</th>
                <th>Balance</th>
                <th>Desciption</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user['UserID'] }}</td>
                <td>{{ $user['Email'] }}</td>
                <td>{{ $user['FirstName'] }}</td>
                <td>{{ $user['LastName'] }}</td>
                <td>{{isset($user['RoleName']) ? $user['RoleName'] : ''}}</td>
                @if ($type == \App\Enum\QueryType::Shares->value)
                <td>{{ $user['CWIOP'] ?? '' }}</td>
                <td>{{ $user['CWISC'] ?? '' }}</td>
                <td>{{ $user['WalletType'] ?? '' }}</td>
                @if (isset($user['Balance']))
                <td>{{ number_format($user['Balance'], 4, '.', ',') ?? ''}}</td>
                @endif
                <td>{{ $user['Description'] ?? '' }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="sync-button">
    {{ $action->getModalAction('sync') }}
</div>
