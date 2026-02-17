<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des réservations — CKF Motors</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1a1a1a; font-size: 11px; }

        .header { background: #0a0a0a; color: #fff; padding: 20px 30px; display: table; width: 100%; }
        .header-left { display: table-cell; vertical-align: middle; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; }
        .brand { font-size: 20px; font-weight: 800; letter-spacing: 4px; color: #c4a35a; }
        .brand-sub { font-size: 10px; color: #888; letter-spacing: 2px; margin-top: 2px; }
        .doc-title { font-size: 14px; font-weight: 700; color: #c4a35a; }
        .doc-date { font-size: 10px; color: #999; margin-top: 2px; }

        .content { padding: 20px 30px; }

        .stats { margin-bottom: 15px; }
        .stat { display: inline-block; background: #f5f5f5; padding: 8px 16px; margin-right: 10px; border-radius: 4px; }
        .stat-value { font-size: 18px; font-weight: 800; color: #c4a35a; }
        .stat-label { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #888; }

        table.list { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.list th {
            background: #0a0a0a;
            color: #c4a35a;
            padding: 8px 10px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        table.list td { padding: 7px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        table.list tr:nth-child(even) { background: #fafafa; }

        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-confirmed { background: #d1fae5; color: #065f46; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        .footer {
            background: #f8f8f8;
            padding: 12px 30px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 9px;
            color: #888;
        }

        .text-right { text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left">
            <div class="brand">CKF MOTORS</div>
            <div class="brand-sub">LOCATION PREMIUM — ABIDJAN</div>
        </div>
        <div class="header-right">
            <div class="doc-title">LISTE DES RÉSERVATIONS</div>
            <div class="doc-date">
                @if($status)
                    Filtre : {{ match($status) { 'pending' => 'En attente', 'confirmed' => 'Confirmées', 'cancelled' => 'Annulées', default => $status } }}
                    —
                @endif
                Généré le {{ now()->translatedFormat('d F Y à H:i') }}
            </div>
        </div>
    </div>

    <div class="content">

        <div class="stats">
            <div class="stat">
                <div class="stat-value">{{ $reservations->count() }}</div>
                <div class="stat-label">Total</div>
            </div>
            <div class="stat">
                <div class="stat-value">{{ $reservations->where('status', 'confirmed')->count() }}</div>
                <div class="stat-label">Confirmées</div>
            </div>
            <div class="stat">
                <div class="stat-value">{{ $reservations->where('status', 'pending')->count() }}</div>
                <div class="stat-label">En attente</div>
            </div>
            <div class="stat">
                <div class="stat-value">{{ number_format($reservations->where('status', 'confirmed')->sum('estimated_total'), 0, ',', '.') }}</div>
                <div class="stat-label">CA confirmé (FCFA)</div>
            </div>
        </div>

        <table class="list">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Téléphone</th>
                    <th>Véhicule</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Jours</th>
                    <th class="text-right">Total (FCFA)</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->full_name }}</td>
                    <td>{{ $r->phone }}</td>
                    <td>{{ $r->vehicle?->name ?? '—' }}</td>
                    <td>{{ $r->start_date->format('d/m/Y') }}</td>
                    <td>{{ $r->end_date->format('d/m/Y') }}</td>
                    <td>{{ $r->total_days }}</td>
                    <td class="text-right">{{ number_format($r->estimated_total, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $r->status }}">
                            {{ match($r->status) { 'pending' => 'Attente', 'confirmed' => 'Confirmée', 'cancelled' => 'Annulée', default => $r->status } }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="footer">
        <strong>CKF Motors</strong> — Document confidentiel — {{ $reservations->count() }} réservation(s)
    </div>

</body>
</html>
