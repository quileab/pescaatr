<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bienvenidos</title>
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
  <h1>Bienvenidos</h1>
  Los esperamos para disfrutar de la fiesta!!!
  <h3>Equipo: {{ $team['name'] }}</h3>
  Embarcación: {{ $team['boatName'] }} / Matrícula: {{ $team['plate'] }}<br>
  HP: {{ $team['hp'] }}<br>
  Participa Timonel: {{ $team['wheelplay'] ? 'Si' : 'No' }}<br>
  <h3>Participantes:</h3>
  <table>
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Fecha Nacimiento</th>
        <th>Sexo</th>
      </tr>
    </thead>
    <tbody>
      @foreach($team['players'] as $player)
      <tr>
      <td>{{$player['fullname'] ?? 'error'}}</td>
      <td>{{$player['phone'] ?? 'error'}}</td>
      <td>{{$player['email'] ?? 'error'}}</td>
      <td>{{$player['dob'] ?? 'error'}}</td>
      <td>{{$player['sex'] ?? 'error'}}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <hr>
  <h2>Importante</h2>
  Los pagos deben enviarse al CBU: 2850787540095169918958 <i>(Club Atlético y Tiro Reconquista)</i><br>
  Luego de realizado el pago enviar el comprobante al celular <b>3482625556</b> y/o al email:
  <b>pagos@pescavariadaatr.com.ar</b><br>

</body>

</html>