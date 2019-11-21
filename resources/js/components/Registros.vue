<template>
<div>

      <th scope="row">1005190052</th>
      <td>{{ registro.c0541_nombres }} {{ registro.c0541_apellido1 }} {{  registro.c0541_apellido2 }}</td>
      <td>3 de febrero de 1994 </td>
      <td>@mdo</td>

    </div>
    
</template>
<script>
export default {
    props: ['registro']
}
</script>