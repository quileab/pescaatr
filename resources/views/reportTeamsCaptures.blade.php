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
      margin:1cm;
      padding:0;
      border:0;
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

@foreach ($teams as $team)
<div id="content" style="page-break-before: always;">
 <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:1mm;">
  <div style="text-align:center; border:1px solid; padding:2mm;">
  EQUIPO Nº<br><hr>
  <h1>{{ $team->number }}</h1>
  </div>
  <div style="text-align:center; border:0px solid; padding:2mm; display:flex; align-items:center; justify-content: center;">
   <img src="/images/atr.png" style="height:1.8cm; width:auto; display:inline-block;" />
   <div style="font-size:12px; display:inline-block;">TERCER CONCURSO<br>DE PESCA VARIADA<br>DEL JAAUKANIGAS</div>
  </div>
  <div style="text-align:center; border:1px solid; padding:2mm;">
  PEÑA<br><hr>
  {{ $team->name }}
  </div>
 </div>
 <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:1mm; margin-bottom:1mm; margin-top:1mm;">
  @php $count = 0; @endphp
  @foreach ($team->players as $player)
  @php $count++;
  if ($count == 4) {
  break;
  }
  @endphp
  <div style="text-align:center; border:1px solid; padding:2mm;">
  {{ $player->id }} - {{ $player->fullname }}<br>
  {{ $player->phone }}
  </div>

  @endforeach
 </div>

 <div style="display:grid; grid-template-columns: 75% 25%;">
 <div style="text-align:center; border:1px solid;">
  <table style="width:100%; border: 0px solid #0045a5; border-collapse: collapse;
  text-align: center;font-size: 10px;">
   <thead style="text-align: center;">
    <tr>
     <th rowspan="2">ESPECIES</th>
     <th colspan="3">1º Pieza</th>
     <th colspan="3">2º Pieza</th>
    </tr>
    <tr>
     <th>PUNTOS</th>
     <th>SELLO</th>
     <th>FIRMA FISCAL</th>
     <th>PUNTOS</th>
     <th>SELLO</th>
     <th>FIRMA FISCAL</th>
    </tr>
   </thead>
   <tbody>
  @foreach ($species as $specie)
  <tr style="line-height: 0.5cm;">
   <td style="text-align: left; font-size: 8px;"><small>{{ str_pad($specie->id, 2, '0', STR_PAD_LEFT) }}</small>
    {{ $specie->name }}</td>
   <td>{{ $specie->points1 }}</td>
   <td></td>
   <td></td>
   <td>{{ $specie->points2 }}</td>
   <td></td>
   <td></td>
  </tr>   
  @endforeach
   </tbody>
  </table>
 </div>
 <div style="text-align:center; padding:2mm;">
  CANT. ESPECIES<br><div style="width:100%; border:2px solid;"><br><br></div><br>
  CANT. PIEZAS<br><div style="width:100%; border:2px solid;"><br><br></div><br>
  1er. PIEZA MAYOR<br>
  <div style="width:100%; border:1px solid; display:grid; grid-template-columns: repeat(3, 1fr);">
   <div style="border:1px solid;">MEDIDA</div>
   <div style="border:1px solid;">SELLO</div>
   <div style="border:1px solid;">FIRMA</div>
   <div style="border:1px solid;"><br><br></div>
   <div style="border:1px solid;"></div>
   <div style="border:1px solid;"></div>
  </div><br>
  2da. PIEZA MAYOR<br>
  <div style="width:100%; border:1px solid; display:grid; grid-template-columns: repeat(3, 1fr);">
   <div style="border:1px solid;">MEDIDA</div>
   <div style="border:1px solid;">SELLO</div>
   <div style="border:1px solid;">FIRMA</div>
   <div style="border:1px solid;"><br><br></div>
   <div style="border:1px solid;"></div>
   <div style="border:1px solid;"></div>
  </div><br>
  3er. PIEZA MAYOR<br>
  <div style="width:100%; border:1px solid; display:grid; grid-template-columns: repeat(3, 1fr);">
   <div style="border:1px solid;">MEDIDA</div>
   <div style="border:1px solid;">SELLO</div>
   <div style="border:1px solid;">FIRMA</div>
   <div style="border:1px solid;"><br><br></div>
   <div style="border:1px solid;"></div>
   <div style="border:1px solid;"></div>
  </div><br>
  PIEZA DE LEY<br><div style="width:100%; border:2px solid;"><br><br></div><br>
  TOTAL PUNTOS<br><div style="width:100%; border:2px solid;"><br><br></div><br> 
 </div>
 </div>
  <br>
  <b>IMPORTANTE:</b> Una vez finalizado el concurso se dispondrá de un plazo de 10 minutos para dirigirse al inicio de cada
  zona para fiscalizar piezas pendientes. Luego, se otorgarán 20 minutos más para entragar la presente planilla en inicio
  de cancha para ingresar al escalafón por puestos y recibir tarjeta y pulseras almuerzo entrega de premios.
  <br>
</div>
@endforeach