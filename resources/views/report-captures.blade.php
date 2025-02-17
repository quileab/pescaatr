<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Repore Capturas</title>
  <style>
    *,
    *::before,
    *::after {
      box-sizing: border-box;
    }

    * {
      margin: 0;
      padding: 0;
    }

    body {
      text-align: center;
      font-family: Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      font-size: 8pt;
    }

    table {
      border-collapse: collapse;
      border: 0.25mm solid black;
      width: 100%;
      text-align: center;

      td {
        border: 0.25mm solid black;
      }

      th {
        border: 0.25mm solid black;
      }
    }

    h1,
    h2,
    h3,
    h4 {
      margin: 0;
    }

    button {
        border: 0;
        border-radius: 0.5rem;
        background-color: #40f;
        color: #ccc;
        padding: 0.5rem 2rem;
        font-size: 1.2rem;
        font-weight: 400;
        &:hover{
          background-color: #55f;
        }
      }

    #header{
      width:100%;
      background-color: rgb(24, 0, 90);
      padding:0.5rem;
      text-align: right;
    }

    .list-container {
      display: flex;
      /* border:0.25mm solid blue; */

      .species-table {
        flex-grow: 1;
        /* border:0.25mm solid red; */
      }

      .data-column {
        flex-grow: 1;
        min-width: 0;
        max-width: 5cm;
        padding-left: 5mm;
        /* border:0.25mm solid green; */
      }
    }

    .one-column-square {
      width: 100%;
      border: 1mm solid black;
      height: 18mm;
    }

    .three-column-square {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      grid-template-rows: 1fr 3fr;
      width: 100%;
      border: 1mm solid black;
      height: 25mm;

      .border-thin {
        border: 0.1mm solid black;
      }

    }

    .bg-gray {
      background-color: silver;
    }

    @media print {

      /* All your print styles go here */
      #header,
      #footer,
      #nav {
        display: none !important;
      }

      @page {
        size: A4 portrait;
      }

      table,
      figure {
        page-break-inside: avoid;
        /* Prevent the table from breaking across pages */
      }
    }
  </style>
</head>

<body>
  <div id="header">
    <button onclick="window.print();">🖨️ Imprimir</button>
    <button onclick="window.close();">Cerrar ❌</button>
  </div>

  <div>
    <table>
      <tr>
        <td style="width:4cm;"><small>Equipo</small>
          <br>
          <h1>{{ str_pad($team->number, 4, '0', STR_PAD_LEFT) }}</h1>
        </td>
        <td>
          PRIMER CONCURSO DE PESCA VARIADA DEL JAAUKANIGAS
        </td>
        <td style="width:4cm;">
          <h3>{{ $team->hp }}<small> HP</small></h3>
        </td>
      </tr>
    </table>

    <div style="display:flex; width:100%; flex-wrap:wrap; justify-content: space-between;">
      @foreach ($team->players as $player)
        <div style="display:flex; border:0.25mm solid black; flex-grow: 1; padding: 5mm;">
          <h4>{{ $player->fullname }}</h4>
        </div>
      @endforeach
    </div>

    <div class="list-container">
      <div class="species-table">
        <table>
          <tr>
            <th rowspan="2">
              <h3>ESPECIES</h3>
            </th>
            <th colspan="3">
              <small>1°PIEZA</small>
            </th>
            <th colspan="3">
              <small>2°PIEZA</small>
            </th>
          </tr>
          <tr>
            <th>
              <small>Puntos</small>
            </th>
            <th>
              <small>Sello</small>
            </th>
            <th>
              <small>FIRMA FISCAL</small>
            </th>
            <th>
              <small>Puntos</small>
            </th>
            <th>
              <small>Sello</small>
            </th>
            <th>
              <small>FIRMA FISCAL</small>
            </th>
          </tr>
          @foreach ($captures['species'] as $species)
            <tr style="height: 8mm;">
              <td style="text-alignt:left;">{{ $species['name'] }}</td>
              <td>{{ $species['fish_count'] }}</td>
              <td>{{ $species['fish_count'] }}</td>
              <td>{{ $species['fish_count'] }}</td>
              <td>{{ $species['fish_count'] }}</td>
              <td>{{ $species['fish_count'] }}</td>
              <td>{{ $species['fish_count'] }}</td>
            </tr>
          @endforeach

        </table>

      </div>
      <div class="data-column">
        <br>CANT. ESPECIES
        <div class="one-column-square"></div>
        <br>CANT. PIEZAS
        <div class="one-column-square"></div>
        <br>1° PIEZA MAYOR
        <div class="three-column-square">
          <div class="border-thin min-height">Medida</div>
          <div class="border-thin min-height">Sello</div>
          <div class="border-thin min-height">Firma</div>
          <div class="border-thin max-height"></div>
          <div class="border-thin max-height"></div>
          <div class="border-thin max-height"></div>
        </div>
        <br>2° PIEZA MAYOR
        <div class="three-column-square">
          <div class="border-thin min-height">Medida</div>
          <div class="border-thin min-height">Sello</div>
          <div class="border-thin min-height">Firma</div>
          <div class="border-thin max-height"></div>
          <div class="border-thin max-height"></div>
          <div class="border-thin max-height"></div>
        </div>
        <br>3° PIEZA MAYOR
        <div class="three-column-square">
          <div class="border-thin min-height">Medida</div>
          <div class="border-thin min-height">Sello</div>
          <div class="border-thin min-height">Firma</div>
          <div class="border-thin max-height"></div>
          <div class="border-thin max-height"></div>
          <div class="border-thin max-height"></div>
        </div>
        <br>PIEZA DE LEY
        <div class="one-column-square"></div>
        <br>TOTAL PUNTOS
        <div class="one-column-square"></div>
      </div>


    </div>

  </div>

</body>

</html>
