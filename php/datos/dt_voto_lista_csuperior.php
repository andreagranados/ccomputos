<?php
class dt_voto_lista_csuperior extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_acta,id_lista,cant_votos FROM voto_lista_csuperior ";
		return toba::db('ccomputos')->consultar($sql);
	}


//obtiene el listado de voto_lista_csuperior correspondientes al acta que recibe como parametro del acta 
        function get_listado_votos_sup($acta)
	{
		
		$sql = "SELECT
                        t_v.id_acta,
                        t_v.id_lista,
			t_l.nombre,
			t_v.cant_votos
			
		FROM
			voto_lista_csuperior as t_v, lista_csuperior as t_l	
                WHERE t_l.id_nro_lista=t_v.id_lista and t_v.id_acta=".$acta;
		
		return toba::db('ccomputos')->consultar($sql);
	}

	function get_listado()
	{
		$sql = "SELECT
			t_vlc.id_lista,
			t_a.id_acta as id_acta_nombre,
			t_lc.nombre as id_lista_nombre,
			t_vlc.cant_votos
		FROM
			voto_lista_csuperior as t_vlc	LEFT OUTER JOIN acta as t_a ON (t_vlc.id_acta = t_a.id_acta)
			LEFT OUTER JOIN lista_csuperior as t_lc ON (t_vlc.id_lista = t_lc.id_nro_lista)";
		return toba::db('ccomputos')->consultar($sql);
	}

}
?>