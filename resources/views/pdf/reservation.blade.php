<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation #{{ $reservation->id }} — CKF Motors</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1a1a1a; font-size: 13px; line-height: 1.6; }

        .header { background: #0a0a0a; color: #fff; padding: 30px 40px; display: table; width: 100%; }
        .header-left { display: table-cell; vertical-align: middle; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; }
        .brand { font-size: 24px; font-weight: 800; letter-spacing: 4px; color: #c4a35a; }
        .brand-sub { font-size: 11px; color: #888; letter-spacing: 2px; margin-top: 4px; }
        .doc-title { font-size: 18px; font-weight: 700; color: #c4a35a; }
        .doc-ref { font-size: 12px; color: #999; margin-top: 4px; }

        .content { padding: 30px 40px; }

        .status-badge {
            display: inline-block;
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-confirmed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }

        .section { margin-bottom: 25px; }
        .section-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #c4a35a;
            border-bottom: 2px solid #c4a35a;
            padding-bottom: 6px;
            margin-bottom: 15px;
        }

        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 8px 12px; border-bottom: 1px solid #f0f0f0; vertical-align: top; }
        .info-table .label { font-weight: 600; color: #666; width: 40%; font-size: 12px; }
        .info-table .value { color: #1a1a1a; }

        .total-row td { border-top: 2px solid #0a0a0a; border-bottom: none; }
        .total-row .value { font-size: 18px; font-weight: 800; color: #c4a35a; }

        .two-cols { display: table; width: 100%; }
        .col { display: table-cell; width: 48%; vertical-align: top; }
        .col-spacer { display: table-cell; width: 4%; }

        .footer {
            background: #f8f8f8;
            padding: 20px 40px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 11px;
            color: #888;
        }
        .footer strong { color: #0a0a0a; }

        .note-box {
            background: #fafafa;
            border-left: 3px solid #c4a35a;
            padding: 12px 16px;
            font-size: 12px;
            color: #555;
            margin-top: 10px;
        }

        .watermark {
            position: fixed;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 80px;
            font-weight: 900;
            color: rgba(196,163,90,0.06);
            letter-spacing: 10px;
            white-space: nowrap;
            z-index: -1;
        }
    </style>
</head>
<body>

    <div class="watermark">CKF MOTORS</div>

    {{-- En-tête --}}
    <div class="header">
        <div class="header-left">
            <div class="brand">CKF MOTORS</div>
            <div class="brand-sub">LOCATION PREMIUM — ABIDJAN</div>
        </div>
        <div class="header-right">
            <div class="doc-title">BON DE RÉSERVATION</div>
            <div class="doc-ref">Réf. #{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }} — {{ $reservation->created_at->format('d/m/Y') }}</div>
        </div>
    </div>

    <div class="content">

        {{-- Statut --}}
        <div class="section" style="text-align: right;">
            <span class="status-badge status-{{ $reservation->status }}">
                @switch($reservation->status)
                    @case('pending') En attente @break
                    @case('confirmed') Confirmée @break
                    @case('cancelled') Annulée @break
                @endswitch
            </span>
        </div>

        <div class="two-cols">
            {{-- Client --}}
            <div class="col">
                <div class="section">
                    <div class="section-title">Informations client</div>
                    <table class="info-table">
                        <tr>
                            <td class="label">Nom complet</td>
                            <td class="value">{{ $reservation->full_name }}</td>
                        </tr>
                        <tr>
                            <td class="label">Email</td>
                            <td class="value">{{ $reservation->email }}</td>
                        </tr>
                        <tr>
                            <td class="label">Téléphone</td>
                            <td class="value">{{ $reservation->phone }}</td>
                        </tr>
                        @if($reservation->license_seniority)
                        <tr>
                            <td class="label">Ancienneté permis</td>
                            <td class="value">{{ $reservation->license_seniority }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="col-spacer"></div>

            {{-- Véhicule --}}
            <div class="col">
                <div class="section">
                    <div class="section-title">Véhicule réservé</div>
                    <table class="info-table">
                        <tr>
                            <td class="label">Véhicule</td>
                            <td class="value">{{ $reservation->vehicle?->name ?? '—' }}</td>
                        </tr>
                        @if($reservation->vehicle?->brand)
                        <tr>
                            <td class="label">Marque</td>
                            <td class="value">{{ $reservation->vehicle->brand }}</td>
                        </tr>
                        @endif
                        @if($reservation->vehicle?->model)
                        <tr>
                            <td class="label">Modèle</td>
                            <td class="value">{{ $reservation->vehicle->model }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        {{-- Détails réservation --}}
        <div class="section">
            <div class="section-title">Détails de la réservation</div>
            <table class="info-table">
                <tr>
                    <td class="label">Date de début</td>
                    <td class="value">{{ $reservation->start_date->translatedFormat('l d F Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Date de fin</td>
                    <td class="value">{{ $reservation->end_date->translatedFormat('l d F Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Durée</td>
                    <td class="value">{{ $reservation->total_days }} jour(s)</td>
                </tr>
                @if($reservation->vehicle?->price_per_day)
                <tr>
                    <td class="label">Tarif journalier</td>
                    <td class="value">{{ number_format($reservation->vehicle->price_per_day, 0, ',', '.') }} FCFA</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td class="label" style="font-size: 14px; font-weight: 800;">TOTAL ESTIMÉ</td>
                    <td class="value">{{ number_format($reservation->estimated_total, 0, ',', '.') }} FCFA</td>
                </tr>
            </table>
        </div>

        {{-- Notes --}}
        @if($reservation->notes)
        <div class="section">
            <div class="section-title">Notes & précisions</div>
            <div class="note-box">{{ $reservation->notes }}</div>
        </div>
        @endif

    </div>

    {{-- Pied de page --}}
    <div class="footer">
        <p><strong>CKF Motors</strong> — Location de véhicules premium — Abidjan, Côte d'Ivoire</p>
        <p>Document généré le {{ now()->translatedFormat('d F Y à H:i') }} — Usage interne uniquement</p>
    </div>

</body>
</html>
