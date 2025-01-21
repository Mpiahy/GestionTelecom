<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Telecom {{ $annee }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            padding-top: 80px;
        }
        .header h1 {
            font-size: 20px;
            color: #0056b3;
        }
        .logo {
            position: absolute;
            top: 0;
            right: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 10px;
        }
        table th {
            background-color: #f4f4f4;
            color: #333;
            font-size: 11px;
        }
        .footer {
            text-align: right;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Logo en haut à droite -->
        <img src="{{ public_path('assets/img/COLAS.png') }}" class="logo" width="201" height="63" alt="Logo">

        <!-- Titre -->
        <h1>Tableau de bord Telecom {{ $annee }}</h1>
        <p>Résumé des chiffres par type de ligne</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Type ligne</th>
                @foreach($moisFrancais as $mois)
                    <th>{{ $mois }}</th>
                @endforeach
                <th>Total Année</th>
            </tr>
        </thead>                
        <tbody>
            @foreach($data as $type => $values)
                <tr>
                    <td>{{ $type }}</td>
                    @foreach(range(1, 12) as $mois)
                        <td>{{ number_format($values[$mois]['total_prix_forfait_ht'] ?? 0, 2, ',', ' ') }}</td>
                    @endforeach
                    <td>{{ number_format($values['total_annuel'] ?? 0, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Généré le {{ now()->format('d/m/Y') }}
    </div>
</body>
</html>
