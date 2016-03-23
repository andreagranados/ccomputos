<?php
class dt_voto_lista_cdirectivo extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_lista,cant_votos  FROM voto_lista_cdirectivo ORDER BY id_lista";
		return toba::db('ccomputos')->consultar($sql);
	}


//obtiene el listado de voto_lista_cdirectivo correspondientes al acta que recibe como parametro del acta 
        function get_listado_votos_dir($acta)
	{
		
		$sql = "SELECT
                        t_v.id_acta,
                        t_v.id_lista,
			t_l.nombre,
			t_v.cant_votos
			
		FROM
			voto_lista_cdirectivo as t_v, lista_cdirectivo as t_l	
                WHERE t_l.id_nro_lista=t_v.id_lista and t_v.id_acta=".$acta;
		
		return toba::db('ccomputos')->consultar($sql);
	}



}
?>