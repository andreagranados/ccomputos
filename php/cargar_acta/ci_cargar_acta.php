<?php
class ci_cargar_acta extends toba_ci
{
	protected $s__datos_filtro;
        protected $s__acta;
        protected $s__datos_acta;
        protected $s__pantalla;

        //evento volver de las pantallas
        function evt__volver($datos)
	{ 
            if ($this->s__pantalla== "pant_votsup"){
               $this->set_pantalla("pant_edicion");
            }else{ if($this->s__pantalla== "pant_votdir"){
                        $this->set_pantalla("pant_votsup");}
                 }
        }
        
        function evt__siguiente()
	{
		$this->set_pantalla("pant_votdir");
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
	      $this->pantalla()->tab("pant_votsup")->desactivar();
              $this->pantalla()->tab("pant_votdir")->desactivar();

              if (isset($this->s__datos_filtro)) {
			$cuadro->set_datos($this->dep('datos')->tabla('acta')->get_listado($this->s__datos_filtro));
		} else {
			$cuadro->set_datos($this->dep('datos')->tabla('acta')->get_listado());
		}
	}

	function evt__cuadro__seleccion($datos)
	{
                $this->dep('datos')->tabla('acta')->cargar($datos);
                $this->s__acta=$datos;

	}
        
        function evt__cuadro__editar($datos)
	{
		$this->dep('datos')->tabla('acta')->cargar($datos);
                $this->s__acta=$datos;
                $this->set_pantalla('pant_votsup'); 
                
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		if ($this->dep('datos')->tabla('acta')->esta_cargada()) {
                    $form->set_datos($this->dep('datos')->tabla('acta')->get());
		}
	}

       
	function evt__formulario__alta($datos)
	{
		
                $this->dep('datos')->tabla('acta')->nueva_fila($datos);
		$this->dep('datos')->tabla('acta')->sincronizar();
		$this->resetear();

	}
        


	function evt__formulario__modificacion($datos)
	{
		$this->dep('datos')->tabla('acta')->set($datos);
		$this->dep('datos')->tabla('acta')->sincronizar();
		$this->resetear();
	}
        

	function evt__formulario__baja()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}
        


	function evt__formulario__cancelar()
	{
		$this->resetear();
	}

	function resetear()
	{
		$this->dep('datos')->resetear();
	}
//--Pantalla Voto Superior
        function conf__pant_votsup()
	{
		$this->s__pantalla = "pant_votsup";
	} 
        
        //formulario encabezado
        function conf__encabezado(toba_ei_formulario $form)
	{
            if (isset($this->s__acta)) {
			$form->set_datos($this->s__acta);
		}
        }
        //cuadro cuadro_vsup
      	function conf__cuadro_vsup(toba_ei_cuadro $cuadro)
	{
	      $this->pantalla()->tab("pant_edicion")->desactivar();
              $this->pantalla()->tab("pant_votdir")->desactivar();
              $id=$this->s__acta['id_acta'];
              //busca los votos superiores del acta seleccionada previamente
	      $cuadro->set_datos($this->dep('datos')->tabla('voto_lista_csuperior')->get_listado_votos_sup($id));
		
	}
        
        function evt__cuadro_vsup__seleccion($datos)
	{
		$this->dep('datos')->tabla('voto_lista_csuperior')->cargar($datos);
	}
        
                
        
        //formulario form_vsup
        //para que vengan los datos como parametro debe estar tildado el tilde Manejo de Datos cuando se define el evento del formulario en el toba-editor
        function conf__form_vsup(toba_ei_formulario $form)
        {
            if ($this->dep('datos')->tabla('voto_lista_csuperior')->esta_cargada()) {  
			$form->set_datos($this->dep('datos')->tabla('voto_lista_csuperior')->get());
		}    
        }
        

        function evt__form_vsup__modificacion($datos)
	{
		$this->dep('datos')->tabla('voto_lista_csuperior')->nueva_fila($datos);
		$this->dep('datos')->tabla('voto_lista_csuperior')->sincronizar();
		$this->resetear();
	}

        function evt__form_vsup__baja()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

        function evt__form_vsup__cancelar()
	{
		$this->resetear();
	}

        
        function evt__form_vsup__guardar($datos)
	{  
            $datos['id_acta']=$this->s__acta['id_acta'];
            $this->dep('datos')->tabla('voto_lista_csuperior')->set($datos);
	    $this->dep('datos')->tabla('voto_lista_csuperior')->sincronizar();
	    $this->resetear();
        }
        //--Pantalla Voto Directivo
        function conf__pant_votdir()
	{
            $this->s__pantalla = "pant_votdir";
	} 
        //formulario encabezadod
        function conf__encabezadod(toba_ei_formulario $form)
	{
            if (isset($this->s__acta)) {
			$form->set_datos($this->s__acta);
		}
        }
        //cuadro cuadro_vdir
      	function conf__cuadro_vdir(toba_ei_cuadro $cuadro)
	{
	      $this->pantalla()->tab("pant_edicion")->desactivar();
              $this->pantalla()->tab("pant_votsup")->desactivar();
              $id=$this->s__acta['id_acta'];
              //trae un listado de los votos de las listas del consejo directivo
	      $cuadro->set_datos($this->dep('datos')->tabla('voto_lista_cdirectivo')->get_listado_votos_dir($id));
		
	}
        function evt__cuadro_vdir__seleccion($datos)
	{
		$this->dep('datos')->tabla('voto_lista_cdirectivo')->cargar($datos);
	}
        
        //formulario form_vdir
        function conf__form_vdir(toba_ei_formulario $form)
        {
            if ($this->dep('datos')->tabla('voto_lista_cdirectivo')->esta_cargada()) {  
			$form->set_datos($this->dep('datos')->tabla('voto_lista_cdirectivo')->get());
		}    
        }
        function evt__form_vdir__modificacion($datos)
	{
		$this->dep('datos')->tabla('voto_lista_cdirectivo')->set($datos);
		$this->dep('datos')->tabla('voto_lista_cdirectivo')->sincronizar();
		$this->resetear();
	}

        function evt__form_vdir__baja()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

        function evt__form_vdir__cancelar()
	{
		$this->resetear();
	}

        
}

?>