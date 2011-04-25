<?php session_start();

	chdir($_SESSION["path"]);
	include ('./BD/query.php');
	include ('./clases/actividad.php');

    function nombre_act($index,$value){
        echo '<input type="text" id="nombre_act'.$index.'" name="nombre_act'.$index.'" value="'.$value.'" size="30px"/>';
    }
    function objet_act($index,$indexObj,$value){
        echo '<input type="checkbox" id="object_act'.$index.'[]" name="object_act'.$index.'[]" value="'.$indexObj.'" size="20em"/>';
		
	}

    function borrar($index){
        echo '<div class="trasher"><img src="images/delete.png" id="borrar'.$index.'" width="32px" class="trash"/></div>';
    }

	$actividades= new actividad();
	$actividades = $actividades->get(NULL);
?>

<h2>Actividades</h2>
<br>
<form id ="new_actividad" name ="new_actividad" action="acciones/agregar_actividad.php" method="post" >
<input type="hidden" name="escondido" id="escondido" value="1"/>
<input type="hidden" name="contador" id="contador" value="0"/>

<div id="list_act" style="float:right; margin-right:25px;"> 

	<table id="newAct">
		<tr>
			<th style="width:200px;"><h3>Nombre</h3></th>
			<th colspan="5"><h3>Objetivos</h3></th>
			<th style="height:50px" >
				<div class="adder"><image src="images/add.png" id="addrow" width="24px"/></div></th>
		</tr>
	
		<tr>
			<td> </td>
			<?php
				for ($j=1; $j<=5; $j++){
					echo '<td style="width:20px;"> '.$j.' </td>';
				}
			?>
			<td></td>
		</tr>
    
		<?php 
			$class = "odd";
			for($row = 0; $row < 1; $row++){
				$class = ($class == "odd") ? "even" : "odd";
				echo '<tr class="'.$class.'"> 
				<td align="center">';   
					nombre_act($row,"");
				echo '</td>';
		
			for ($obj = 1; $obj <=5; $obj++){
				echo '<td align="center">';
				objet_act($row,$obj,"1");
				echo '</td>';       
			}
			echo '<td>';
			borrar($row);
			echo '</td> </tr>';
			}
		?>    
	</table>

	<div style="text-align:right; margin-right:140px;">
		<br>
		<a id="save" href="#" ><img src="./images/guardarB.png" style="border:0;"/></a>
		<br>
		<br>
	</div>
	</div>

</form>

<div id="list_act" style="margin-left:50px; width:327px">

	<table>
		<tr>
			<th style="width:200px;"><h3>Nombre</h3></th>
			<th colspan="5"><h3>Objetivos</h3></th>
		</tr>
	
		<tr>
			<td></td>
			<?php
				for ($j=1; $j<=5; $j++){
					echo '<td style="width:20px;"td> '.$j.' </td>';
				}
			?>
		</tr>
	
		<?php
			$class == "odd";
			foreach ($actividades as $actividad){
				$class = ($class == "odd") ? "even" : "odd";
				echo '<tr class="'.$class.'">'
		?>
		<td style="text-align:left;"> <?php echo $actividad->nombre."";?></td>
		<?php
			for ($k = 0; $k <= 4; $k++){
				if (substr($actividad->objetivos,$k,1)=="1"){ ?> <td class="cruz"> X </td>
				<?php }else {?> <td></td> <?php } 
			}?>
		</tr>
		<?php
		} ?>
	
	
</table>

</div>

<script type="text/javascript" src="js/jquery.simpletip-1.3.1.js"></script>
<script type="text/javascript">

$(".trash").each(function() {
    $(this).click(function () {
        var answer = confirm("Está seguro de que desea eliminar esta fila?")

    	if (answer){
    		$(this).parent().parent().parent().remove();
            $("#contador").val(parseInt($("#contador").val())+1);
    	}
    });
});
$(document).ready(function (){
	$("#save").click(function () {
		document.new_actividad.submit();
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
    var contador = parseInt($("#contador").val());
	if (id-contador<4) {
	var clase = (id%2 ==0 ) ? "odd" : "even";
    var html = '<tr class="'+clase+'">'
        +'<td align="center">'
            +'<input type="text" size="30px" id="nombre_act'+id+'" name="nombre_act'+id+'">'
        +'</td>' 
		+'<td align="center">'
            +'<input type="checkbox" id="object_act'+id+'[]" name="object_act'+id+'[]" value="1" size="20em"/>'
        +'</td>'
		+'<td align="center">'
            +'<input type="checkbox" id="object_act'+id+'[]" name="object_act'+id+'[]" value="2" size="20em"/>'
        +'</td>'
		+'<td align="center">'
            +'<input type="checkbox" id="object_act'+id+'[]" name="object_act'+id+'[]" value="3" size="20em"/>'
        +'</td>'
		+'<td align="center">'
            +'<input type="checkbox" id="object_act'+id+'[]" name="object_act'+id+'[]" value="4" size="20em"/>'
        +'</td>'
		+'<td align="center">'
            +'<input type="checkbox" id="object_act'+id+'[]" name="object_act'+id+'[]" value="5" size="20em"/>'
        +'</td>'
        
         +'<td align="center" width="38px"><div class="trasher"><img width="32px" class="trash" id="borrar'+id+'" src="images/delete.png"/></div></td>'
    +'</tr>';
    
//    var text = "<tr><td>hola</td></tr>";
    $('#newAct tr:last').after(html);
    
    $("#escondido").val(id+1);
	
	$("#borrar"+id).click(function () {
		var answer = confirm("Está seguro de que desea eliminar esta fila?")
		if (answer){
            $(this).parent().parent().parent().remove();
            $("#contador").val(parseInt($("#contador").val())+1);
		}
	});
    all();
	}
});

</script>

	
