<?php session_start();

    function userid($index,$value){
        echo '<input type="text" id="userid'.$index.'" name="userid'.$index.'" value="'.$value.'" size="15em"/>';
    }
    function correo($index,$value){
        echo '<input type="text" id="correo'.$index.'" name="correo'.$index.'" value="'.$value.'" size="20em"/>';
    }
    
    function tipo($index){	
		echo '<select id="tipo'.$index.'" name="tipo'.$index.'">
				<option value= "Estudiante" selected>Estudiante activo</option>
				<option value= "Estudiante_No">Estudiante no activo</option>
				<option value= "Coordinador">Coordinador</option>
			 </select>';
    }

    function borrar($index){
        echo '<div class="trasher"><img src="images/delete.png" id="borrar'.$index.'" width="32px" class="trash"/></div>';
    }	
var_dump("llegue");
?>
		
<form id ="usuario" name ="usuario" action="acciones/registrar_usuarios.php" method="post" >
<input type="hidden" name="escondido" id="escondido" value="5"/>
<div id="lol"> 
<center>
<h2>Usuarios</h2>
<table id="new_usuario" >
    <tr>
        <th><h3>C&eacute;dula</h3></th>
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
        userid($row,"");
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
$("#userid0").after('<span class="error">algo</span>');
function validateEmail(elementValue){  
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
	return emailPattern.test(elementValue);  
}  

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
	var id = parseInt($("#escondido").val());
	for(var i=0;i<id;i++){
		var cedulaVal = $("#userid"+id).val();
		if(cedulaVal<=0 || cedulaVal=="" || isNaN(cedulaVal)){	
			$("#userid"+id).after('<span class="error">La cedula no es válida.</span>');
			hasError = true;
		}
		
		var correoVal = $("#correo"+id).val();
		if(!validateEmail(correoVal)){	
			$("#correo"+id).after('<span class="error">El correo no es válido.</span>');
			hasError = true;
		}
	}

	$("#save").click(function () {

        if (!hasError) {
            document.usuario.submit();
        }
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
            +'<input type="text" size="15em" id="userid'+id+'" name="userid'+id+'">'
        +'</td>' 
		+'<td align="center">'
            +'<input type="text" size="20em" id="correo'+id+'" name="correo'+id+'">'
        +'</td>'
        + '<td><select id="tipo'+id+'" name="tipo'+id+'">'
				+'<option value= "Estudiante" selected="selected">Estudiante Activo</option>'
				+'<option value= "Estudiante_No">Estudiante No Activo</option>'
				+'<option value= "Coordinador">Coordinador</option>'
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

	
