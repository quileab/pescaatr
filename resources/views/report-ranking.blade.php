<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>RANKING</title>
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
@php
  $prizes=['🥇','🥈','🥉'];
  $default='✔️';
@endphp

<body>
  <div id="header">
    <button onclick="window.print();">🖨️ Imprimir</button>
    <button onclick="window.close();">Cerrar ❌</button>
  </div>

  <div>
    <h1>RANKING</h1>
    <table style="width:60%; margin:1rem auto;">
      @foreach ($ranking as $position => $team)
      <tr>
        <td><h1>{{ $prizes[$position] ?? $default  }}</h1></td>
        <td><h2>{{ $team['name'] }}</h2></td>
        <td><h2>{{ $team['points'] }}</h2></td>
      </tr>
      @endforeach
    </table>
  </div>

</body>

</html>
