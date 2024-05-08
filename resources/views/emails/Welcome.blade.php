<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bienvenidos</title>
</head>
<style>
  body{
    font-family: Arial, Helvetica, sans-serif;
    padding:1rem;
  }
  table{
    width: 100%;
    border-collapse: collapse;
    border-radius: 0.5rem;
    overflow: hidden;
  }
  th{
    background-color: #0045a5;
    color: #ffffff;
  }
  td,th{
    padding:0.5rem;
  }
  tr:nth-child(even) {
    background-color: #c3dcfe;
  }
  tr:nth-child(odd) {
    background-color: #dfecff;
  }
  h3{
    margin-top:0.2rem;
  }
</style>
<body>
  <h1>Bienvenidos</h1>
  Los esperamos para disfrutar de la fiesta!!!
  <h3>Equipo: {{ $team['name'] }}</h3>
  Embarcación: {{ $team['boatName'] }} # {{ $team['plate'] }}<br>
  <h3>Participantes:</h3>
  <table>
    <thead><tr><th>Nombre</th><th>Teléfono</th><th>Email</th></tr></thead>
    <tbody>
    @foreach($team['players'] as $player)
    <tr>
      <td>{{$player['fullname']}}</td>
      <td>{{$player['phone']}}</td>
      <td>{{$player['email']}}</td>
    </tr>
    @endforeach
    </tbody>
  </table>
  
</body>
</html>