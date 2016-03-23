<?php
class dt_lista_cdirectivo extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_nro_lista, nombre FROM lista_cdirectivo ORDER BY nombre";
		return toba::db('ccomputos')->consultar($sql);
	}






	function get_listado()
	{
		$sql = "SELECT
			t_lc.id_nro_lista,
			t_ue.nombre as id_ue_nombre,
			t_lc.nombre
		FROM
			lista_cdirectivo as t_lc	LEFT OUTER JOIN unidad_electoral as t_ue ON (t_lc.id_ue = t_ue.id_nro_ue)
		ORDER BY nombre";
		return toba::db('ccomputos')->consultar($sql);
	}

}
?>