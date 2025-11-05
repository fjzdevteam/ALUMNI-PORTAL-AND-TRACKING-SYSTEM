<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $info['title'] }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 30px;
            color: #222;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        .info {
            text-align: center;
            font-size: 13px;
            color: #555;
            margin-bottom: 30px;
        }

        table {
            width: 95%;
            border-collapse: collapse;
            margin: 0 auto 30px auto;
            font-size: 13px;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #f4f4f4;
            font-weight: bold;
        }

        .chart {
            text-align: center;
            margin: 35px auto;
            page-break-inside: avoid;
            width: 100%;
        }

        .chart img {
            display: block;
            max-width: 350px;
            width: 90%;
            height: auto;
            object-fit: contain;
            margin: 0 auto;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 45px;
        }
    </style>
</head>

<body>
    <h1>{{ $info['title'] }}</h1>

    <p class="info">
        <strong>Batch:</strong> {{ $info['batch'] }} &nbsp;|&nbsp;
        <strong>Generated on:</strong> {{ $info['date'] }}
    </p>

    <h2>Dashboard Summary</h2>
    <table>
        <tr>
            <th>Total Alumni</th>
            <td>{{ $summary['total_alumni'] }}</td>
        </tr>
        <tr>
            <th>Female Alumni</th>
            <td>{{ $summary['female'] }}</td>
        </tr>
        <tr>
            <th>Male Alumni</th>
            <td>{{ $summary['male'] }}</td>
        </tr>
        <tr>
            <th>New Registrations (This Month)</th>
            <td>{{ $summary['new_month'] }}</td>
        </tr>
    </table>

    <h2>Analytics Charts</h2>
    @foreach ($chartImages as $title => $image)
        <div class="chart">
            <h3>{{ ucfirst($title) }} Chart</h3>
            @if ($image)
                <img src="{{ $image }}" alt="{{ $title }} Chart">
            @else
                <p><em>No chart available</em></p>
            @endif
        </div>
    @endforeach

    <div class="footer">
        <p>© {{ date('Y') }} PLP Alumni Analytics</p>
    </div>
</body>

</html>
