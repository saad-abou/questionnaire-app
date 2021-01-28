<html>
    <head>
    </head>
    <body>
        <table>
            <tr>
                <th><b>Users</b></th>
                <th><b>Score</b></th>
            </tr>

            @foreach($users as $index => $user)
            <tr>
                <td>{{ $user->name}}</td>
                <td>{{ $user->score}}</td>
            </tr>
            @endforeach
        </table>
    </body>
</html>
