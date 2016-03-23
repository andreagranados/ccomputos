<?php
class dt_acta extends toba_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_a.id_acta,
			t_a.total_votos_blancos,
			t_a.total_votos_nulos,
			t_a.total_votos_recurridos,
			t_s.nombre as id_sede_nombre,
			t_t.descripcion as id_tipo_nombre
		FROM
			acta as t_a	LEFT OUTER JOIN sede as t_s ON (t_a.id_sede = t_s.id_sede)
			LEFT OUTER JOIN tipo as t_t ON (t_a.id_tipo = t_t.id_tipo)";
		return toba::db('ccomputos')->consultar($sql);
	}






        
        

	function get_descripciones()
	{
		$sql = "SELECT id_acta, id_acta FROM acta ORDER BY id_acta";
		return toba::db('ccomputos')->consultar($sql);
	}

}
?>