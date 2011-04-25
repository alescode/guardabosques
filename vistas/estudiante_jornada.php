<?php session_start();

	 function select($id, $value,$scale,$min,$max){
        echo '<select id="'.$id.'" name="'.$id.'" class="timer" >';
        for ($i = $min; $i*$scale <$max; $i++){
            $option = ($value == $i*$scale) ? '<option selected="SELECTED">' : "<option>";            
            $option.= $i*$scale."</option>";
            echo $option;
        }
        echo "</select>";
    }
    
    function actividad($index,$value,$actividades,$actividad){
        echo '<select id="actividad'.$index.'" name="actividad'.$index.'" class="actividades">';
			echo '<option '; if (!$actividad){echo 'SELECTED ';} echo 'value="-1">--Seleccione--</option>';
		foreach( $actividades as $act){		
			if($actividad){
				echo '<option '; if ($actividad->act_id==$act->act_id){echo 'SELECTED ';} echo 'value='.$act->objetivos.$act->act_id.'>'.$act->nombre.'</option>';
			}else{
				echo '<option value='.$act->objetivos.$act->act_id.'>'.$act->nombre.'</option>';
			}
		} 
		echo '</select>';
    }
	
    function descripcion($index,$value){
        echo '<textarea id="descripcion'.$index.'" name="descripcion'.$index.'" style="width:250px;height:40px" >'.$value.'</textarea>';
    }
    
    function total($index,$value){    
        echo '<input type="text" id="total'.$index.'" name="total'.$index.'" value="'.$value.'" size="6"readonly="true"/>';
    }
    
    function borrar($index){
        echo '<div class="trasher"><img src="images/delete.png" id="borrar'.$index.'" name="borrar'.$index.'" width="32px" class="trash"/></div>';
    }
	
	chdir($_SESSION["path"]);
	include ("./BD/query.php");
	include ("./clases/actividad.php");
	include ("./clases/jornada.php");
	$actividades=new actividad();
	$actividades=$actividades->get(NULL);
	
	//$jornada=$_SESSION["id_jornada"];
	if(isset($_GET['idj'])){
		$jornada= new Jornada();
		$jornada->jornada_id=$_GET['idj'];
		$_SESSION["id_jornada"]=$_GET['idj'];
		$jornada=$jornada->get(NULL);
		$jornada=$jornada[0];
	}else{
		$jornada=NULL;
	}
	if($jornada){
		echo "<h2> Editar Jornada </h2>";
	}else{
		echo "<h2> A&ntilde;adir Jornada </h2>";
	}
	
?>
<script>

$("#save").click(function(){				

	var error=false;
    var size = $("#size").val();
	
	//verificacion de que si existe una actividad tenga las horas en que se realizo.
	for (i = 0 ; i < size; i++){
		var elem = $("#actividad"+i).val();

		if (elem > 0){
				
				var hi = parseInt($("#h_i_"+i).val());
				var hf = parseInt($("#h_f_"+i).val());
				var mi = parseInt($("#m_i_"+i).val());
				var mf = parseInt($("#m_f_"+i).val());
               
				var h = hf - hi;
				var m = mf - mi; 
				var total= h + m/60;
				if (total<=0)
				{
					error=true;
					$("#actividad"+i).after('<span class="error">La actividad debe realizarse en horas positivas.</span>');
				}
		}
	}
	var fecha_j= $("#date").val();
	if(fecha_j==""){
		error=true;
		$("#date").after('<span class="error">La jornada debe tener la fecha en la que se realiz&oacute;.</span>');
	}
	
	if(!error){
		document.jornada.submit();
	}
	return false;
});

$("#save2").click(function(){				

	var error=false;
    var size = $("#size").val();
	
	//verificacion de que si existe una actividad tenga las horas en que se realizo.
	for (i = 0 ; i < size; i++){
		var elem = $("#actividad"+i).val();

		if (elem > 0){
				
				var hi = parseInt($("#h_i_"+i).val());
				var hf = parseInt($("#h_f_"+i).val());
				var mi = parseInt($("#m_i_"+i).val());
				var mf = parseInt($("#m_f_"+i).val());
               
				var h = hf - hi;
				var m = mf - mi; 
				var total= h + m/60;
				if (total<=0)
				{
					error=true;
					$("#actividad"+i).after('<span class="error">La actividad debe realizarse en horas positivas.</span>');
				}
		}
	}
	var fecha_j= $("#date").val();
	if(fecha_j==""){
		error=true;
		$("#date").after('<span class="error">La jornada debe tener la fecha en la que se realiz&oacute;.</span>');
	}
	
	if(!error){
		document.jornada_edit.submit();
	}
	return false;
});


</script>
<?php if($jornada){?>
<form id ="jornada_edit"  name="jornada_edit" action="acciones/editar_jornada.php" method="post" enctype="multipart/form-data">
<?php }else{?>
<form id ="jornada"  name="jornada" action="acciones/insertar_jornadas.php" method="post" enctype="multipart/form-data">
<?php }?>
    <div style="float:left;display:inline"><h3 align="left" style="text-align:left;margin-left:50px" >Fecha: <div id="datepicker" name="datepicker" style="float:left"> </div>
		<input type="text" id="date" name="date" readonly="true" size="8" value="<?php if($jornada){echo $jornada->fecha;}?>"/></h3>
	</div>
	<div align="right" style="text-align:left;margin-right:20px;float:right;" >
		Objetivos:<br/>
        <?php if($jornada){ $objetivos = $jornada->objetivos;?>
			<input id="objetivo0" name="objetivo[]" value=0 type="checkbox" <?php if($objetivos[0]=='1'){echo "checked";}?>/> Educaci&oacute;n y sensibilizaci&oacute;n a visitantes y vecinos de la USB.<br/>
			<input id="objetivo1" name="objetivo[]" value=1 type="checkbox" <?php if($objetivos[1]=='1'){echo "checked";}?>/> Manejo y restauraci&oacute;n ambiental.<br/>
			<input id="objetivo2" name="objetivo[]" value=2 type="checkbox" <?php if($objetivos[2]=='1'){echo "checked";}?>/> Protecci&oacute;n ambiental y de los visitantes.<br/>
			<input id="objetivo3" name="objetivo[]" value=3 type="checkbox" <?php if($objetivos[3]=='1'){echo "checked";}?>/> Seguimiento e informaci&oacute;n ambiental.<br/>
			<input id="objetivo4" name="objetivo[]" value=4 type="checkbox" <?php if($objetivos[4]=='1'){echo "checked";}?>/> Institucionalizaci&oacute;n y promoci&oacute;n del programa.<br/>
		<?php }else{?>
			<input id="objetivo0" name="objetivo[]" value=0 type="checkbox" /> Educaci&oacute;n y sensibilizaci&oacute;n a visitantes y vecinos de la USB.<br/>
			<input id="objetivo1" name="objetivo[]" value=1 type="checkbox" /> Manejo y restauraci&oacute;n ambiental.<br/>
			<input id="objetivo2" name="objetivo[]" value=2 type="checkbox" /> Protecci&oacute;n ambiental y de los visitantes.<br/>
			<input id="objetivo3" name="objetivo[]" value=3 type="checkbox" /> Seguimiento e informaci&oacute;n ambiental.<br/>
			<input id="objetivo4" name="objetivo[]" value=4 type="checkbox" /> Institucionalizaci&oacute;n y promoci&oacute;n del programa.<br/>			
		<?php }?>
	</div>
    <input type="hidden" id="size" name="size" value="5"/>

<br/><br/><br/><br/><br/><br/><br/><br/>
<div id="lol"> 
<table id="new_jornada" >
    <tr>
        <th><h3>Actividad<h3></th>
        <th><h3>Descripci&oacute;n<h3></th>
        <th><h3>Hora de Inicio<h3></th>
        <th><h3>Hora de Fin<h3></th>
        <th><h3>Duraci&oacute;n<h3></th>
		<th width="38x" style="height:50px" >
			<div class="adder"><image src="images/add.png" id="addrow" width="24px"/></div></th>
    </tr>
    
    <?php 
    $class = "odd";
	if ($jornada){ if (count($jornada->list_realiza)>5){$c=count($jornada->list_realiza);}else{$c=5;}}else{$c=5;}
    for($row = 0; $row < $c; $row++){
        $class = ($class == "odd") ? "even" : "odd";
        echo '<tr class="'.$class.'">
                <td align="center">';
		if($jornada){
			if (count($jornada->list_realiza)>$row){
				actividad($row,"",$actividades,$jornada->list_realiza[$row]);
				echo '</td>
                <td align="center">';
                descripcion($row,$jornada->list_realiza[$row]->desc);
				 echo '</td>
                <td align="center">';
				select("h_i_".$row, (int)substr($jornada->list_realiza[$row]->hora_inicio,0,2),1,0,24);
                select("m_i_".$row, (int)substr($jornada->list_realiza[$row]->hora_inicio,3,5),5,0,60);
				echo '</td>
					<td align="center">';
				select("h_f_".$row, (int)substr($jornada->list_realiza[$row]->hora_fin,0,2),1,0,24);            
				select("m_f_".$row, (int)substr($jornada->list_realiza[$row]->hora_fin,3,5),5,0,60);
				echo '</td>
					<td align="center">';
				$h= (int)substr($jornada->list_realiza[$row]->hora_fin,0,2) - (int)substr($jornada->list_realiza[$row]->hora_inicio,0,2);
				$m= (int)substr($jornada->list_realiza[$row]->hora_fin,3,5)-(int)substr($jornada->list_realiza[$row]->hora_inicio,3,5);
				total($row,$h."h".$m."m");   
			}else{
				actividad($row,"",$actividades,NULL);
				echo '</td>
                <td align="center">';
				descripcion($row,"");
				 echo '</td>
                <td align="center">';
				select("h_i_".$row, 0,1,0,24);
                select("m_i_".$row, 0,5,0,60);
				echo '</td>
					<td align="center">';
				select("h_f_".$row, 0,1,0,24);            
				select("m_f_".$row, 0,5,0,60);
				echo '</td>
					<td align="center">';
				   total($row,"0h0m");   
			}

		}else{
			actividad($row,"",$actividades,NULL);
			echo '</td>
                <td align="center">';
            descripcion($row,"");
			 echo '</td>
                <td align="center">';
			select("h_i_".$row, 0,1,0,24);
			select("m_i_".$row, 0,5,0,60);
			echo '</td>
					<td align="center">';
			select("h_f_".$row, 0,1,0,24);            
			select("m_f_".$row, 0,5,0,60);
			echo '</td>
					<td align="center">';
		    total($row,"0h0m");     
		}	   
        echo '</td>
                <td align="center" width="38px">';
        borrar($row);
        echo '</td>
            </tr>';       
    }
    ?>
        
</table>
	<div>
		<br>
		<?php if($jornada){?>
		<a id="save2" name="save2" href="#" ><img src="./images/guardarB.png" style="border:0;"/></a>
		<?php }else{?>
		<a id="save" name="save" href="#" ><img src="./images/guardarB.png" style="border:0;"/></a>
		<?php }?>
		<br>
		<br>
	</div>
</div>
</form>
<script type="text/javascript" src="js/jquery.simpletip-1.3.1.js"></script>
<script type="text/javascript" src="js/estudiante_jornada.js"></script>
<script type="text/javascript">

$(".trash").click(function () {
    var answer = confirm("Está seguro de que desea eliminar esta fila?")
	if (answer){
		$(this).parent().parent().parent().remove();
	}
});

$(".adder").simpletip({
               content: 'Agregar Fila ',
               fixed: true, 
               position: 'right' 
});

 function setObjetivos() {
	var nuevo = $(this).val();
	var size = $("#size").val();
	var resultado = "00000";
		var lol;
	for (i = 0 ; i < 5; i++){
		$("#objetivo"+i).attr('checked', false);
	}
	
	for (i = 0 ; i < size; i++){
		var elem = $("#actividad"+i).val();
		lol = "";
		if (elem > 0){
			for (j = 0 ; j < 5; j++){
				if  (elem.charAt(j) == "1"  ||  resultado.charAt(j)=="1"){
					$("#objetivo"+j).attr('checked', true);
					lol = lol+'1';
				} else {
					$("#objetivo"+j).attr('checked', false);
					lol = lol+'0';
				}
			}
			resultado = lol;
		}
	}
	
}

$(".actividades").change(function(){
	setObjetivos();
	}
	);

$(".trasher").simpletip({
               content: 'Borrar Fila',
               fixed: true, 
               position: 'right' 
});


$("#addrow").click(function(){
    var id = parseInt($("#size").val());
    var select = $('#actividad1').parent().html();
	select = select.replace(/actividad1/g,"actividad"+id);
    var clase = (id%2 !=0 ) ? "odd" : "even";
    var html = '<tr class="'+clase+'">'
        +'<td align="center">'
		+ select
        +'</td>'
        +'<td align="center">'
            +'<textarea style="width: 20em; height: 48px;" id="descripcion'+id+'"></textarea></td>'
         +'<td align="center"><select class="timer" id="h_i_'+id+'"><option selected="SELECTED">0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option></select><select class="timer" id="m_i_'+id+'"><option selected="SELECTED">0</option><option>5</option><option>10</option><option>15</option><option>20</option><option>25</option><option>30</option><option>35</option><option>40</option><option>45</option><option>50</option><option>55</option></select></td>'
         +'<td align="center"><select class="timer" id="h_f_'+id+'"><option selected="SELECTED">0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option></select><select class="timer" id="m_f_'+id+'"><option selected="SELECTED">0</option><option>5</option><option>10</option><option>15</option><option>20</option><option>25</option><option>30</option><option>35</option><option>40</option><option>45</option><option>50</option><option>55</option></select></td>'
         +'<td align="center"><input type="text" readonly="true" size="6" value="0h0m" id="total'+id+'"/></td>'
         +'<td align="center" width="38px"><div class="trasher"><img width="32px" class="trash" id="borrar'+id+'" name="borrar'+id+'" src="images/delete.png"/></div></td>'
    +'</tr>';
    
//    var text = "<tr><td>hola</td></tr>";
    $('#new_jornada tr:last').after(html);
    
	$("#borrar"+id).click(function () {
		var answer = confirm("Está seguro de que desea eliminar esta fila?")
		if (answer){
			$(this).parent().parent().parent().remove();
		}
	});
	
	$("#actividad"+id).change(function(){
		setObjetivos();
	})
	;
    id = id+1;
    $("#size").val(id);
	
    all();
});

</script>

	
