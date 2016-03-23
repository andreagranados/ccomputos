<?php
class dt_lista_csuperior extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_nro_lista, nombre FROM lista_csuperior ORDER BY nombre";
		return toba::db('ccomputos')->consultar($sql);
	}





}
?>