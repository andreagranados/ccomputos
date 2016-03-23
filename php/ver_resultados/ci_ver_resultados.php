<?php
class ci_ver_resultados extends toba_ci
{
	protected $s__datos_filtro;


        function conf__pant_edicion(){
                $this->pantalla('pant_edicion')->colapsar();
                echo '<html>';
                echo '<head>';
                echo "<script type='text/javascript'>";
                echo "function mostrar(){".
                        "if(document.formulario.resultado[1].checked==true){".//si esta tildada la opcion Superior
                            "document.getElementById('cs').style.display='block';".
                            "document.getElementById('detallecs').style.display='block';".
                            "}".
                        "else{document.getElementById('cs').style.display='none';".
                              "document.getElementById('detallecs').style.display='none';".
                            "}".
                        "if(document.formulario.resultado[0].checked==true){".
                            "document.getElementById('cd').style.display='block';"
                        . "document.getElementById('detallecd').style.display='block';".
                            "}".
                        "else{document.getElementById('cd').style.display='none';".
                             "document.getElementById('detallecd').style.display='none';".
                            "}".
                        "}";//fin de la funcion
                echo "function dependencia(select,arreglo){".
                        "alert(select.value);".
                        "arreglo[0]=select.value;".
                        "}";
                
                echo "</script>";
        
                echo "<style type='text/css'>  ";
                echo ".tabla        {   
                          display: table; color:black;  margin-left:20px; }  ";//margin-top:70px;
                echo ".celda  { 
                        color:black;
			display: table-cell;  
                        border: solid;  
                        border-width: thin;  
                        padding-left: 5px;  
                        padding-right: 5px;  
                    }  ";
                echo ".fila        {  
                        display: table-row;  
			font-family:Arial;	
			font-size:10pt;}  ";
                echo ".texto{color:black;font-family:Arial;font-size:10pt;}";
                echo ".heading  {  
                        display: table-row;  
                        font-weight: bold;  
                        text-align: center;  }  ";
                echo "</style>";
                echo '</head>';
                echo '<body>';
                echo "<br>";echo "<br>";echo "<br>";echo "<br>"; echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";
                echo "<div class='texto'>Que resultados desea ver?";
                echo "<form name='formulario' method='post'";
                echo "<br><input type='radio' name='resultado' value='1' onclick='mostrar()'  > Directivo ";
                echo "<br><input type='radio' name='resultado' value='2'  onclick='mostrar()'> Superior";
                echo "<br>";echo "<br>";
                $dep=array();
                echo "<select name='dependencia' onchange='dependencia(this,".$dep.")' required/>";
                echo "<option selected disabled>Seleccione una opci&oacute;n</option>";
                echo "<option value='1' >Administración Central</option>";
                echo "<option value='2' >Centro Regional Universitario Bariloche</option>";
                echo "<option value='3' >Centro Regional Zona Atlántica</option>";
                echo "</select>";
                print_r($dep);
                
                $this->generar_hondt_sup_estud();        
                $this->generar_hondt_dir_estud();        
                echo "</form>";
                echo "</div>";
                echo '</body>';
                
                echo '</html>';
        
        
        }
        function generar_hondt_sup_estud()
        {
            $cant_cargos_sup_estud=10;
            $tipo=1;//consejo superior
            //recuperamos las listas del consejo superior
            $sql = "select t_l.* from lista_csuperior t_l order by id_nro_lista;";
            $res = toba::db('ccomputos')->consultar($sql);    
            
            echo "<div class='tabla' id='cs' style='display:none'>"; 
            echo "<div class='fila'>  ";
            echo "<b>CONSEJO SUPERIOR</b>";
            echo "</div>";
            echo "<div class='fila'>  ";
            echo "<div class='celda'>";
            echo "<b>"."SEDES"."</b>";
            echo "</div>";
             
            foreach ($res as $lista) {
                echo "<div class='celda'>";
                echo "<b>".utf8_decode($lista['nombre'])."</b>";
                echo "</div>";
             
            }
            echo "</div>";//clase fila
            
	    $total_votos_sup=0;//para sumar todos los votos de todas las listas
            //recupero todas las sedes
            $sql = "select t_s.* from sede t_s";
            $res_sede = toba::db('ccomputos')->consultar($sql);    
            
            foreach ($res_sede as $sed) {//para cada sede
                    
                    $id_sede=$sed['id_sede'];
                    $nom_sede=$sed['nombre'];
                    $divisor=$sed['cant_emp'];
                    echo "<div class='fila'>";
                    echo "<div class='celda'>";
                    echo "<b>".utf8_decode($nom_sede)."</b>";
                    echo "</div>"; 
                    foreach ($res as $lista){//para cada lista, Las recupero en el mismo orden en el que las liste en la fila anterior (ordenadas por id_nro_lista)
                        $id_lista=$lista['id_nro_lista'];
                        //obtengo la cantidad de votos para esa sede y esa lista
                        //sum(t_v.cant_votos)
                        //devuelve la cantidad de votos de una lista de una sede.
                        // no se suma!
                        $consulta="select t_v.cant_votos as votos ".
                            "from voto_lista_csuperior t_v, lista_csuperior t_l ".
                            "where t_l.id_nro_lista=t_v.id_lista and ".
                            " exists(select * from acta t_a ".
                            " where t_a.id_tipo=1 and ".
                            "t_a.id_acta=t_v.id_acta and ".
                            "t_a.id_sede=".$id_sede.")".
                            "and t_l.id_nro_lista=".$id_lista;
                                //" group by t_l.nombre";
                        $result=toba::db('ccomputos')->consultar($consulta);
                        echo "<div class='celda'>";
                        if (count($result)>0){
                            echo $result[0]['votos'];
                            $total_votos_sup=$total_votos_sup+$result[0]['votos'];
                            //print_r("sede".$sed['nombre']."   total votos".$total_votos_sup);
                         }else {
                             echo "0";
                             }
                        echo "</div>";//celda
                      }   
                       echo "</div>";//fila
                    }
                   
                echo "</div>";//class='tabla'
                
                
                //--------------tabla con el detalle del calculo
                

                echo "<div class='tabla' id='detallecs' style='display:none'>"; 
                echo "<p><b>Detalles (Sistema D'Hondt) Consejo Superior</b></p>";
                //fila
                echo "<div class='fila'>  ";
                echo "<div class='celda'>";
                echo "";
                echo "</div>";

                $totales=array();//arreglo con la lista donde cada elemento: $clave=indice de la lista $valor: total de cargos obtenidos de esa lista
                $divisores=array();//arreglo con los divisores de cada fila
                $ponderados=array();
                foreach ($res as $clave=>$lista){//inicializo todo en 0
                    $ponderados[$lista['id_nro_lista']]=0;
                 }
                //recupero todas las ue
                $sql = "select t_u.* from unidad_electoral t_u";
                $res_ue = toba::db('ccomputos')->consultar($sql);    
                
                //calculo los ponderados de cada lista
                foreach ($res_ue as $valor){
                    $cant_empad=$valor['cant_empadronados'];
                    $id=$valor['id_nro_ue'];
                    $cons="select t_v.id_lista,sum(cant_votos) as cant_votos".
                            " from sede t_s, acta t_a, voto_lista_csuperior t_v ".
                            " where  t_a.id_sede=t_s.id_sede and t_v.id_acta=t_a.id_acta and t_s.id_ue=".$id
                            ." group by t_v.id_lista";
                    $resultado=toba::db('ccomputos')->consultar($cons);
                    if (count($resultado)>0){
                    foreach ($resultado as $clave=>$valor) {
                        $ponderados[$valor['id_lista']]+=$valor['cant_votos']/$cant_empad;
                         }
                         }               
                }
                
                foreach ($res as $clave=>$lista){//para cada lista
                   $nom = utf8_decode($lista['nombre']);   
                   $totales[$lista['id_nro_lista']]=0;//cantidad de cargos que se lleva cada lista
                   $divisores[$lista['id_nro_lista']]=1;//divisor por el que tenemos que dividir en cada iteracion
                   echo "<div class='celda'>";
                   echo "<b>".$nom."</b>";
                   echo "</div>";//celda
                }
                echo "</div>";//cierra fila
                
                echo "<div class='fila'>  ";//abro fila
                echo "<div class='celda'>";
                echo "<b>"."Votos Ponderados"."</b>";
                echo "</div>";//celda
                foreach ($ponderados as $valor) {
                    echo "<div class='celda'>";
                    echo $valor;
                    echo "</div>";
                    
                }
                echo "</div>";//fin de fila
                
                //preparo el arreglo calculo con los votos de cada lista
                $total_votos=0;//suma de los votos de todas las listas
                $calculo=array();//valores a mostrar en cada iteracion
                foreach ($ponderados as $clave=>$valor) {
                    $calculo[$clave]=$valor;
                }
                               
                $mayor_valor=-1;
                $mayor_indice=0;
                $iteracion=1;
                
                while ($iteracion<=$cant_cargos_sup_estud) {//10 es el número de cargos electos
                    echo "<div class='fila'>  ";//abro fila
                    echo "<div class='celda'>";
                    echo "<b>"."Cargo ".$iteracion."</b>";
                    echo "</div>";//celda  
                    $mayor_valor=-1;    
                    
                    //calculo los valores a mostrar en esta fila
                    foreach ($ponderados as $clave=>$valor){
                        $calculo[$clave]=($ponderados[$clave]/$divisores[$clave]);
                        if($mayor_valor<$calculo[$clave]){    
                            $mayor_valor=$calculo[$clave];
                            $mayor_indice=$clave;
                        }
                    }
                    foreach ($calculo as $valor){//muestro los elementos del calculo previo
                        echo "<div class='celda'>";
                        echo $valor;
                        echo "</div>";//cierra celda                    
                     }
                    //preparo para la siguiente iteracion
                    $divisores[$mayor_indice]=$divisores[$mayor_indice]+1;//incremento el divisor de la lista ganadora
                    $calculo[$mayor_indice]=$ponderados[$mayor_indice]/$divisores[$mayor_indice];
                    $totales[$mayor_indice]=$totales[$mayor_indice]+1;//incremento en 1 el mayor de la ronda anterior
                    $iteracion=$iteracion+1;
                    echo "</div>";//cierro fila  
                }//fin del while
                
                echo "<div class='fila'>  ";//abro fila
                echo "<div class='celda'>";
                echo "<b>"."Total Cargos Electos"."</b>";
                echo "</div>";
                foreach ($totales as $value) {
                    echo "<div class='celda'>";
                    echo $value;
                    echo "</div>";
                }
                echo "</div>";
                
                //calculo el porcentaje de votos de cada lista = votos de la lista/total de votos del consejo superior 
                $porcentaje_votos=array();
                //$sql="select sum(cant_votos) as total from voto_lista_csuperior";
                //$tv=toba::db('ccomputos')->consultar($sql);
                //$total_votos_sup=$tv[0]['total'];
                foreach ($res as $clave => $lista) {//para cada lista superior obtengo el total de votos obtenidos
                    $porcentaje_votos[$clave]=0;
                    $sql="select sum(cant_votos) as total_lista from voto_lista_csuperior where id_lista=".$lista['id_nro_lista'];
                    $resul=toba::db('ccomputos')->consultar($sql);
                    $porcentaje_votos[$clave]=$resul[0]['total_lista']/$total_votos_sup;
                    
                }
                //muestro el porcentaje de votos
                echo "<div class='fila'>  ";//abro fila
                echo "<div class='celda'>";
                echo "<b>"."% Votos"."</b>";
                echo "</div>";
                foreach ($porcentaje_votos as $value) {
                    echo "<div class='celda'>";
                    //echo round(round($value*100)/100)." %";
                    echo $value;
                    echo "</div>";
                }
                echo "</div>";
                
                echo "<div class='fila'>  ";//abro fila
                echo "<div class='celda'>";
                echo "<b>"."% Cargos"."</b>";
                echo "</div>";
                foreach ($totales as $value) {
                    echo "<div class='celda'>";
                    $val=$value/10*100;
                    echo $val." %";
                    echo "</div>";
                }
                echo "</div>";
                
                echo "</div>";//tabla
            
                
                
             }//fin de la funcion
            
	function generar_hondt_dir_estud()
        {
                
                $cant_cargos_sup_estud=4;
                $tipo=2;//consejo directivo
                //recuperamos las listas del consejo directivo de una sede
                $sql = "select t_l.* from lista_cdirectivo t_l where id_ue=9 order by id_nro_lista;";
                $res = toba::db('ccomputos')->consultar($sql);    
                
                
                echo "<div class='tabla' id='cd' style='display:none'>"; 
                echo "<p><b>"."CONSEJO DIRECTIVO "."</b></p>";
                
                echo "<div class='fila'>  ";
                echo "<div class='celda'>";
                echo "<b>"."SEDES"."</b>";
                echo "</div>";
             
                foreach ($res as $clave=>$lista) {//para cada lista
                    echo "<div class='celda'>";
                    echo "<b>".utf8_decode($lista['nombre'])."</b>";
                    echo "</div>";
                } 
                echo "</div>";//clase fila
                
                $total_votos_dir=0;//para sumar todos los votos de todas las listas del c directivo de esa UE
                //recupero las sedes de esa unidad electoral
                $sql = "select t_s.* from sede t_s where id_ue=9";
                $res_sede = toba::db('ccomputos')->consultar($sql);    
            
                foreach ($res_sede as $sed) {//para cada sede    
                    $id_sede=$sed['id_sede'];
                    $nom_sede=$sed['nombre'];
                    $divisor=$sed['cant_emp'];
                    echo "<div class='fila'>";
                    echo "<div class='celda'>";
                    echo "<b>".utf8_decode($nom_sede)."</b>";
                    echo "</div>"; 
                    foreach ($res as $lista){//para cada lista
                        $id_lista=$lista['id_nro_lista'];
                        //obtengo la cantidad de votos para esa sede y esa lista
                        $consulta="select sum(t_v.cant_votos) as votos ".
                            "from voto_lista_cdirectivo t_v, lista_cdirectivo t_l ".
                            "where t_l.id_nro_lista=t_v.id_lista and ".
                            " exists(select * from acta t_a ".
                            " where t_a.id_tipo=2 and ".
                            "t_a.id_acta=t_v.id_acta and ".
                            "t_a.id_sede=".$id_sede.")".
                            "and t_l.id_nro_lista=".$id_lista.
                            " group by t_l.nombre";
                        $result=toba::db('ccomputos')->consultar($consulta);
                        echo "<div class='celda'>";
                        if (count($result)>0){
                            echo $result[0]['votos'];
                            $total_votos_dir=$total_votos_dir+$result[0]['votos'];
                         }else {
                             echo "0";
                             }
                        echo "</div>";//celda
                      }   
                       echo "</div>";//fila
                    }
                echo "</div>";//fin de la tabla
                
                //--------------tabla con el detalle del calculo
                
                echo "<div class='tabla' id='detallecd' style='display:none'>"; 
                echo "<p><b>Detalles (Sistema D'Hondt) Consejo Directivo</b></p>";
                //fila
                echo "<div class='fila'>  ";
                echo "<div class='celda'>";
                echo "";
                echo "</div>";

                $totales=array();//arreglo con la lista donde cada elemento: $clave=indice de la lista $valor: total de cargos obtenidos de esa lista
                $divisores=array();//arreglo con los divisores de cada fila
                
                               
                $calculo_totales=array();//valores a mostrar en cada iteracion
                $total_votos=0;//suma de los votos de todas las listas
                $listas=array();//aqui todos los id de lista
                
                //inicializo el totales y divisores
                foreach ($res as $clave=>$lista){//para cada lista del directivo
                   $listas[$clave]=$lista['id_nro_lista']; 
                   $nom = utf8_decode($lista['nombre']);   
                   $totales[$lista['id_nro_lista']]=0;//cantidad de cargos que se lleva cada lista
                   $divisores[$lista['id_nro_lista']]=1;//divisor por el que tenemos que dividir en cada iteracion
                   
                   //calculo el total de votos de cada lista
                   $sql="select sum(cant_votos) as cant_votos from voto_lista_cdirectivo where id_lista=".$lista['id_nro_lista'];
                   $resultado=toba::db('ccomputos')->consultar($sql);
                   //print_r($resultado);Array ( [0] => Array ( [cant_votos] => ) ) es lo que devuelve cuanto no trae resultados
                   if($resultado[0]['cant_votos']!=null){
                       $calculo_totales[$lista['id_nro_lista']]=$resultado[0]['cant_votos'];
                       $total_votos=$total_votos+$resultado[0]['cant_votos'];}
                   echo "<div class='celda'>";
                   echo "<b>".$nom."</b>";
                   echo "</div>";//celda
                }
                
                echo "</div>";//cierra fila
                
                echo "<div class='fila'>  ";//abro fila
                echo "<div class='celda'>";
                echo "<b>"."Votos Totales"."</b>";
                echo "</div>";//celda
                foreach ($calculo_totales as $valor) {
                    echo "<div class='celda'>";
                    echo $valor;
                    echo "</div>";
                    
                }
                echo "</div>";//fin de fila
                
                //print_r($calculo_totales);Array ( [48] => 244 ) 
                 //preparo el arreglo calculo con los votos de cada lista
                $calculo=array();//valores a mostrar en cada iteracion
                foreach ($calculo_totales as $clave=>$valor) {
                    $calculo[$clave]=$valor;
                }
                $mayor_valor=-1;
                $mayor_indice=0;//si nunca se modifica y el 0 no estuviera definido en divisores
                $iteracion=1;
                
                while ($iteracion<=$cant_cargos_sup_estud) {//4 es el número de cargos electos
                    echo "<div class='fila'>  ";//abro fila
                    echo "<div class='celda'>";
                    echo "<b>"."Cargo ".$iteracion."</b>";
                    echo "</div>";//celda  
                    $mayor_valor=-1;    
                    
                    //inicializo el arreglo para mostrar en cada iteracion
                    //calculo los valores a mostrar en esta fila
                    //print_r($divisores);exit();
                    foreach ($calculo_totales as $clave=>$valor){
                       $calculo[$clave]=($calculo_totales[$clave]/$divisores[$clave]);
                       // $calculo[$clave]=($calculo_totales[$clave]);
                        if($mayor_valor<$calculo[$clave]){    
                            $mayor_valor=$calculo[$clave];
                            $mayor_indice=$clave;
                        }
                    }
                    foreach ($calculo as $valor){//muestro los elementos del calculo previo
                        echo "<div class='celda'>";
                        echo $valor;
                        echo "</div>";//cierra celda                    
                     }
                    //preparo para la siguiente iteracion
                    if (in_array($mayor_indice , $listas)){//si el indice es un id de lista valido
                        $divisores[$mayor_indice]=$divisores[$mayor_indice]+1;//incremento el divisor de la lista ganadora
                        $calculo[$mayor_indice]=$calculo_totales[$mayor_indice]/$divisores[$mayor_indice];
                        $totales[$mayor_indice]=$totales[$mayor_indice]+1;//incremento en 1 el mayor de la ronda anterior
                        
                    } 
                        $iteracion=$iteracion+1;
                        echo "</div>";//cierro fila  
                  }//fin del while
                
                echo "<div class='fila'>  ";//abro fila
                echo "<div class='celda'>";
                echo "<b>"."Total Cargos Electos"."</b>";
                echo "</div>";
                foreach ($totales as $value) {
                    echo "<div class='celda'>";
                    echo $value;
                    echo "</div>";
                }
                echo "</div>";
                
                //calculo el porcentaje de votos de cada lista = votos de la lista/total de votos del consejo directivo de esa UE 
                $porcentaje_votos=array();
                
                foreach ($res as $lista) {//para cada lista superior de esa UE obtengo el total de votos obtenidos
                    $porcentaje_votos[$lista['id_nro_lista']]=0;
                    $sql="select sum(t_v.cant_votos) as total_lista  from voto_lista_cdirectivo t_v,lista_cdirectivo t_l where t_v.id_lista=t_l.id_nro_lista and t_l.id_ue=".$lista['id_ue'];
                    $resul=toba::db('ccomputos')->consultar($sql);
                    
                    if ($total_votos_dir!=0) {
                        $porcentaje_votos[$lista['id_nro_lista']]=$resul[0]['total_lista']/$total_votos_dir;
                    }
                }
                //muestro el porcentaje de votos
                echo "<div class='fila'>  ";//abro fila
                echo "<div class='celda'>";
                echo "<b>"."% Votos"."</b>";
                echo "</div>";
                
                foreach ($porcentaje_votos as $value) {
                    echo "<div class='celda'>";
                    //echo round(round($value*100)/100)." %";
                    echo ($value*100)."%";
                    echo "</div>";
                }
                echo "</div>";
                
                echo "<div class='fila'>  ";//abro fila
                echo "<div class='celda'>";
                echo "<b>"."% Cargos"."</b>";
                echo "</div>";
                
                foreach ($totales as $value) {
                    echo "<div class='celda'>";
                    $val=$value/4*100;
                    echo $val." %";
                    echo "</div>";
                }
                echo "</div>";
                
                echo "</div>";//tabla
            
        }
	
}

?>