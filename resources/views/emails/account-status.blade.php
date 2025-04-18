<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>Estado de Cuenta</title>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<style>
  body {
    font-family: Arial, Helvetica, sans-serif;
    padding: 1rem;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 0.5rem;
    overflow: hidden;
  }

  th {
    background-color: #0045a5;
    color: #ffffff;
  }

  td,
  th {
    padding: 0.5rem;
  }

  tr:nth-child(even) {
    background-color: #c3dcfe;
  }

  tr:nth-child(odd) {
    background-color: #dfecff;
  }

  h3 {
    margin-top: 0.2rem;
  }
</style>

<body>
  <h1>Estado de Cuenta {{ $team['name'] }}</h1>

  <table style="width:100%; border: 1px solid #0045a5;">
    <thead style="background-color: #0045a5; color: #ffffff; text-align: center;">
      <tr>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Monto</th>
      </tr>
    </thead>
    <tbody>
      @php
    $total = 0;
    @endphp
      @foreach ($payments as $payment)
        @php
        $total += $payment['amount'];
        if ($payment['notes'] == 'inscription') {
        $payment['notes'] = 'Inscripción';
        }
        $payment['amount'] = number_format($payment['amount'], 2, ',', '.');
        $payment['date'] = date('d-m-Y', strtotime($payment['date']));
    @endphp
        <tr>
        <td>{{ $payment['date'] }}</td>
        <td>{{ $payment['notes'] }}</td>
        <td style="text-align: right;">{{ $payment['amount'] }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot style="font-weight: bold;">
      <tr>
        <td colspan="2">SALDO</td>
        <td style="text-align: right;">{{ number_format($total, 2, ',', '.') }}</td>
      </tr>
    </tfoot>
  </table>
  <p>Por consultas sobre el estado de su cuenta no dude en comunicarse con:
    <a href="mailto:pagos@pescavariadaatr.com.ar">pagos@pescavariadaatr.com.ar</a>
  </p>
</body>

</html>