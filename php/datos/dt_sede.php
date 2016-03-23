<?php
class dt_sede extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_sede, nombre FROM sede ORDER BY nombre";
		return toba::db('ccomputos')->consultar($sql);
	}



}
?>