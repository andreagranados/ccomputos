<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class ccomputos_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'ccomputos_comando' => 'extension_toba/ccomputos_comando.php',
		'ccomputos_modelo' => 'extension_toba/ccomputos_modelo.php',
		'ccomputos_ci' => 'extension_toba/componentes/ccomputos_ci.php',
		'ccomputos_cn' => 'extension_toba/componentes/ccomputos_cn.php',
		'ccomputos_datos_relacion' => 'extension_toba/componentes/ccomputos_datos_relacion.php',
		'ccomputos_datos_tabla' => 'extension_toba/componentes/ccomputos_datos_tabla.php',
		'ccomputos_ei_arbol' => 'extension_toba/componentes/ccomputos_ei_arbol.php',
		'ccomputos_ei_archivos' => 'extension_toba/componentes/ccomputos_ei_archivos.php',
		'ccomputos_ei_calendario' => 'extension_toba/componentes/ccomputos_ei_calendario.php',
		'ccomputos_ei_codigo' => 'extension_toba/componentes/ccomputos_ei_codigo.php',
		'ccomputos_ei_cuadro' => 'extension_toba/componentes/ccomputos_ei_cuadro.php',
		'ccomputos_ei_esquema' => 'extension_toba/componentes/ccomputos_ei_esquema.php',
		'ccomputos_ei_filtro' => 'extension_toba/componentes/ccomputos_ei_filtro.php',
		'ccomputos_ei_firma' => 'extension_toba/componentes/ccomputos_ei_firma.php',
		'ccomputos_ei_formulario' => 'extension_toba/componentes/ccomputos_ei_formulario.php',
		'ccomputos_ei_formulario_ml' => 'extension_toba/componentes/ccomputos_ei_formulario_ml.php',
		'ccomputos_ei_grafico' => 'extension_toba/componentes/ccomputos_ei_grafico.php',
		'ccomputos_ei_mapa' => 'extension_toba/componentes/ccomputos_ei_mapa.php',
		'ccomputos_servicio_web' => 'extension_toba/componentes/ccomputos_servicio_web.php',
	);
}
?>