------------------------------------------------------------
--[2973]--  Cargar Acta - DR - voto_lista_csuperior 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'ccomputos', --proyecto
	'2973', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_tabla', --clase
	'21', --punto_montaje
	'dt_voto_lista_csuperior', --subclase
	'datos/dt_voto_lista_csuperior.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'Cargar Acta - DR - voto_lista_csuperior', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'ccomputos', --fuente_datos_proyecto
	'ccomputos', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2015-06-06 18:13:12', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_db_registros
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, punto_montaje, ap, ap_clase, ap_archivo, tabla, tabla_ext, alias, modificar_claves, fuente_datos_proyecto, fuente_datos, permite_actualizacion_automatica, esquema, esquema_ext) VALUES (
	'ccomputos', --objeto_proyecto
	'2973', --objeto
	NULL, --max_registros
	NULL, --min_registros
	'21', --punto_montaje
	'1', --ap
	NULL, --ap_clase
	NULL, --ap_archivo
	'voto_lista_csuperior', --tabla
	NULL, --tabla_ext
	NULL, --alias
	'0', --modificar_claves
	'ccomputos', --fuente_datos_proyecto
	'ccomputos', --fuente_datos
	'1', --permite_actualizacion_automatica
	NULL, --esquema
	'public'  --esquema_ext
);

------------------------------------------------------------
-- apex_objeto_db_registros_col
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'ccomputos', --objeto_proyecto
	'2973', --objeto
	'1016', --col_id
	'id_acta', --columna
	'E', --tipo
	'1', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	NULL, --externa
	'voto_lista_csuperior'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'ccomputos', --objeto_proyecto
	'2973', --objeto
	'1017', --col_id
	'id_lista', --columna
	'E', --tipo
	'1', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	NULL, --externa
	'voto_lista_csuperior'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'ccomputos', --objeto_proyecto
	'2973', --objeto
	'1018', --col_id
	'cant_votos', --columna
	'E', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'voto_lista_csuperior'  --tabla
);
--- FIN Grupo de desarrollo 0
