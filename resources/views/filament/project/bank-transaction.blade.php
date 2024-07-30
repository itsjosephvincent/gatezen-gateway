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
        padding: 2px;
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
                <th>Amount</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user['UserID'] }}</td>
                <td>{{ $user['Email'] }}</td>
                <td>{{ $user['FirstName'] }}</td>
                <td>{{ $user['LastName'] }}</td>
                <td>{{ $user['Amount'] }}</td>
                <td>{{ $user['Description'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="sync-button">
    {{ $action->getModalAction('sync') }}
</div>
