<?php
class ci_ver_resultados extends toba_ci
{
	protected $s__datos_filtro;
        protected $s__acta;

        //evento volver de las pantallas
        function evt__volver($datos)
	{ 
            $this->set_pantalla("pant_edicion");
          
        }


	//---- Filtro -----------------------------------------------------------------------

	function conf__filtro(toba_ei_formulario $filtro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
		if (isset($this->s__datos_filtro)) {
			$cuadro->set_datos($this->dep('datos')->tabla('acta')->get_listado($this->s__datos_filtro));
		} else {
                    	$cuadro->set_datos($this->dep('datos')->tabla('acta')->get_listado());
		}
	}

	function evt__cuadro__seleccion($datos)
	{
            $this->set_pantalla("pant_votos");
            $this->s__acta=$datos['id_acta'];
            $this->dep('datos')->tabla('acta')->cargar($datos);
                
	}
        
        
	//--Pantalla Voto
        function conf__encabezado(toba_ei_formulario $form)
        {
               if (isset($this->s__acta)) {
                   $form->set_datos($this->s__acta);
		}
            
        }
        //cuadro cuadro_vsup
      	function conf__cuadro_votos(toba_ei_cuadro $cuadro)
	{
	    $id=$this->s__acta;
            $sql="select * from acta where id_acta=".$id;
            $resultado=toba::db('ccomputos')->consultar($sql);
            $tip=$resultado[0]['id_tipo'];
            if ($tip==1){//consejo superior
                $cuadro->set_datos($this->dep('datos')->tabla('voto_lista_csuperior')->get_listado_votos_sup($id));
            }else {//consejo directivo
                $cuadro->set_datos($this->dep('datos')->tabla('voto_lista_cdirectivo')->get_listado_votos_dir($id));
            }
		
	}
        
}

?>