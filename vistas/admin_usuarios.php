<?php session_start();

    function usbid($index,$value){
        echo '<input type="text" id="usbid'.$index.'" name="usbid'.$index.'" value="'.$value.'" size="15em"/>';
    }
    function correo($index,$value){
        echo '<input type="text" id="correo'.$index.'" name="correo'.$index.'" value="'.$value.'" size="20em"/>';
    }
    
    function tipo($index){	
		echo '<select id="tipo'.$index.'" name="tipo'.$index.'">
				<option value= "Estudiante" selected>Estudiante activo</option>
				<option value= "Estudiante_No">Estudiante no activo</option>
			 </select>';
    }

    function borrar($index){
        echo '<div class="trasher"><img src="images/delete.png" id="borrar'.$index.'" width="32px" class="trash"/></div>';
    }	
?>
		
<form id ="usuario" name ="usuario" action="acciones/registrar_usuarios.php" method="post" >
<input type="hidden" name="escondido" id="escondido" value="5"/>
<div id="lol"> 
<center>
<h2>Usuarios</h2>
<table id="new_usuario" >
    <tr>
        <th><h3>Nombre de usuario (USBID)</h3></th>
        <th><h3>E-mail</h3></th>
        <th><h3>Tipo</h3></th>
		<th width="38x" style="height:50px" >
			<div class="adder"><image src="images/add.png" id="addrow" width="24px"/></div></th>
    </tr>
    
    <?php 
    $class = "odd";
    for($row = 0; $row < 5; $row++){
        $class = ($class == "odd") ? "even" : "odd";
        echo '<tr class="'.$class.'">
                <td align="center">';   
        usbid($row,"");
        echo '</td>
                <td align="center">';
        correo($row,"");
        echo '</td>
                <td align="center">';
		tipo($row);
        echo '</td>
                <td align="center">';
        borrar($row);
        echo '</td>
            </tr>';       
    }
    ?>
        
</table></center>
	<div >
		<br>
		<a id="save" href="#" ><img src="./images/guardarB.png" style="border:0;"/></a>
		<br>
		<br>
	</div>
</div>
</form>
<script type="text/javascript" src="js/jquery.simpletip-1.3.1.js"></script>
<script type="text/javascript">

$(".trash").click(function () {
    var answer = confirm("Está seguro de que desea eliminar esta fila?")
	if (answer){
		$(this).parent().parent().parent().remove();
	}
});

/* @1
$(document).ready(function (){
var carnetReg = /^([0-9]{2})\-([0-9]{4,5})?$/; // expresión regular para validar el carnet

var carnetVal = $("#usbid").val();
if(!carnetReg.test(carnetVal)) {	
    $("#usbid").after('<span class="error">El carnet no es válido. (Ej. XX-XXXXX </span>');
    hasError = true;
}


	$("#save").click(function () {

        if (!hasError) {
            document.usuario.submit();
        }
	});
});*/

$(document).ready(function (){
	$("#save").click(function () {
		document.usuario.submit();
	});
});

$(".adder").simpletip({
               content: 'Agregar fila',
               fixed: true, 
               position: 'right' 
});
$(".trasher").simpletip({
               content: 'Borrar fila',
               fixed: true, 
               position: 'right' 
});

$("#addrow").click(function(){
    var id = parseInt($("#escondido").val());
    
    var clase = (id%2 ==0 ) ? "odd" : "even";
    var html = '<tr class="'+clase+'">'
        +'<td align="center">'
            +'<input type="text" size="15em" id="usbid'+id+'" name="usbid'+id+'">'
        +'</td>' 
		+'<td align="center">'
            +'<input type="text" size="20em" id="correo'+id+'" name="correo'+id+'">'
        +'</td>'
        + '<td><select id="tipo'+id+'" name="tipo'+id+'">'
				+'<option value= "Estudiante" selected="selected">Estudiante activo</option>'
				+'<option value= "Estudiante_No">Estudiante no activo</option>'
	    +'</select></td>'
         +'<td align="center" width="38px"><div class="trasher"><img width="32px" class="trash" id="borrar'+id+'" src="images/delete.png"/></div></td>'
    +'</tr>';
    
//    var text = "<tr><td>hola</td></tr>";
    $('#new_usuario tr:last').after(html);
    
    $("#escondido").val(id+1);
    
	$("#borrar"+id).click(function () {
		var answer = confirm("Está seguro de que desea eliminar esta fila?")
		if (answer){
			$(this).parent().parent().parent().remove();
		}
	});
    all();
});

</script>

	
