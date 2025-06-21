<style>
  * {
    font-family: Arial, Helvetica, sans-serif;
    padding: 0px;
    margin: 0px;
    box-sizing: border-box;
  }

  body {
    margin: 0cm;
    padding: 0cm;
  }

  hr {
    height: 1rem;
    border: 0px;
  }

  h2 {
    margin: 0rem;
    padding: 0rem;
  }

  h4 {
    margin: 0rem;
    padding: 0rem;
  }

  table {
    width: 100%;
    border: 2px solid;
    border-collapse: collapse;
  }

  table td,
  table th {
    border: 1px solid;
    padding: 0.4rem 0.5rem;
  }

  table th {
    border-bottom: 2px solid black;
    background-color: #eee;
  }

  table tr {
    page-break-inside: avoid !important;
  }

  .right {
    text-align: right;
  }

  button {
    color: #ffffff;
    background-color: #2d63c8;
    font-size: 19px;
    border: 1px solid #1b3a75;
    border-radius: 0.5rem;
    padding: 0.5rem 2rem;
    cursor: pointer
  }

  button:hover {
    background-color: #3271e7;
    color: #ffffff;
  }
</style>

<style media="print">
  @media print {

    @page {
      size: legal portrait;
      margin: 1cm;
      padding: 0;
      border: 0;
      box-sizing: border-box;
    }
  }

  .dontPrint {
    display: none;
  }
</style>
<div class="dontPrint"
  style="position:sticky; width:100%; text-align:right; padding:0.4rem; margin-bottom:1rem; background-color: #ddd; border:3px solid #aaa;">
  <button type="button" onclick="window.print();return false;" style=".">🖨️ Imprimir</button>
  <button type="button" onclick="window.close();return false;" style=".">✖️ Cerrar</button>
</div>
<table>
  <thead>
    <tr>
      <th>Equipo</th>
      <th>Nombre/Peña</th>
      <th>Deuda</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($teams as $team)
    <tr>
      <td>{{ $team->number }}</td>
      <td>{{ $team->name }}</td>
      <td class="right">{{ $team->total_debt }}</td>
    @endforeach
  </tbody>
</table>