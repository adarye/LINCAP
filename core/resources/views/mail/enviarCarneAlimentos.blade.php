<!DOCTYPE html>
<html>
<head>
<style>
table, td, th {  
  border: 1px solid #ddd;
  text-align: left;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 11px;
}
</style>
</head>
<body>

<p>Entre <b> {{\Carbon\Carbon::parse($fecha)->format('d/m/Y')}}</b> y <b>{{\Carbon\Carbon::parse($fecha2)->format('d/m/Y')}}</b>, se le vencerá el carnét de alimentos a estos trabajadores:  </p>
<?php  $i = 1 ?>
<table>
  <tr>
    <th>Row</th>
    <th>Cédula</th>
    <th>Nombres</th>
    <th>Apellidos</th>
    <th>Centro de Operacion</th>
    <th>Cargo</th>
    <th>Fecha de ingreso</th>
    <th>Fecha de retiro</th>
    <th>FV de carnét de alimentos</th>
  </tr>
  @foreach($empleados as $emp)
  <tr>
  <th>{{$i++}}</th>
    <td>{{$emp->c0541_id}}</td>
  <td>{{$emp->c0541_nombres}}</td>
  <td>{{$emp->c0541_apellido1}} {{$emp->c0541_apellido2}}</td>
  <td>{{$emp->f285_descripcion}}</td>
  <td>{{$emp->c0763_descripcion}}</td>
  <td>{{\Carbon\Carbon::parse($emp->c0550_fecha_ingreso)->format('d/m/Y')}}</td>
  <td>{{\Carbon\Carbon::parse($emp->c0550_fecha_contrato_hasta)->format('d/m/Y')}}</td>
   <td> {{\Carbon\Carbon::parse($emp->cz9_fv_carne_alimentos)->format('d/m/Y')}}</td> 
  </tr>
  @endforeach
  
</table>

</body>
</html>

