<?php
class dt_unidad_electoral extends toba_datos_tabla
{
	function get_listado()
	{
		$sql = "SELECT
			t_ue.id_nro_ue,
			t_ue.nombre,
			t_ue.cant_empadronados
		FROM
			unidad_electoral as t_ue
		ORDER BY nombre";
		return toba::db('ccomputos')->consultar($sql);
	}

	function get_descripciones()
	{
		$sql = "SELECT id_nro_ue, nombre FROM unidad_electoral ORDER BY nombre";
		return toba::db('ccomputos')->consultar($sql);
	}


}
?>