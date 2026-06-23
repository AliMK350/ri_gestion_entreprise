<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Emploi du temps</title>
    <style>
        body {font-family: DejaVu Sans, sans-serif; font-size: 12px;}
        table {width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td {border: 1px solid #000; padding: 8px; text-align: left;}
        th {background-color: #f2f2f2;}
    </style>
</head>
<body>
    <h1 style="text-align: center;">Emploi du temps</h1>
    @if(isset($seances) && count($seances) > 0)
        <table>
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Heure</th>
                    <th>Matière</th>
                    <th>Salle</th>
                </tr>
            </thead>
            <tbody>
                @foreach($seances as $seance)
                    <tr>
                        <td>{{ $seance->jour ?? '-' }}</td>
                        <td>{{ $seance->heure ?? '-' }}</td>
                        <td>{{ $seance->subject_name ?? '-' }}</td>
                        <td>{{ $seance->salle ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune séance planifiée.</p>
    @endif
</body>
</html>
