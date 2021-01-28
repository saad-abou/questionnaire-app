<html>
    <head>
    </head>
    <body>
        <table>
            <tr>
                <th><b>No</b></th>
                <th><b>Questions</b></th>
                <th><b>Reponses</b></th>
            </tr>
            @foreach($questions as $index => $question)
            <tr>
                <td>{{ ($index+1) }}</td>
                <td width="20">{{ $question->Qst }}</td>
                <td width="20">
                @foreach($question->responses as $choice)
                <p>{{ $choice->rps}} || @if ($question->QstVote){{number_format($choice->vote*100/$question->QstVote, 2)}}%  @endif</p>
                @endforeach
                </td>
            </tr>
            @endforeach
        </table>
    </body>
</html>
