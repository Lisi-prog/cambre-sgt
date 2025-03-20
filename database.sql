CREATE TABLE `sol_prioridad_solicitud` (
  `id_prioridad_solicitud` int NOT NULL AUTO_INCREMENT,
  `nombre_prioridad_solicitud` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_prioridad_solicitud`)
);

CREATE TABLE `sol_estado_solicitud` (
  `id_estado_solicitud` int NOT NULL,
  `nombre_estado_solicitud` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_solicitud`)
);

CREATE TABLE `sol_solicitud` (
  `id_solicitud` int NOT NULL AUTO_INCREMENT,
  `id_prioridad_solicitud` int,
  `id_estado_solicitud` int,
  `nombre_solicitante` varchar(100),
  `descripcion_solicitud` varchar(500) DEFAULT NULL,
  `fecha_carga` datetime,
  `fecha_requerida` date,
  `descripcion_urgencia` varchar(500) DEFAULT NULL,
  `id_servicio` int,
  `id_empleado` int,
  PRIMARY KEY (`id_solicitud`)
);

CREATE TABLE `sol_servicio_requerido` (
  `id_servicio_requerido` int NOT NULL AUTO_INCREMENT,
  `nombre_servicio_requerido` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_servicio_requerido`)
);

CREATE TABLE `activo` (
  `id_activo` int NOT NULL AUTO_INCREMENT,
  `codigo_activo` varchar(150),
  `nombre_activo` varchar(100) DEFAULT NULL,
  `descripcion_activo` varchar(200),
  PRIMARY KEY (`id_activo`)
);

CREATE TABLE `sol_servicio_de_mantenimiento` (
  `id_servicio_de_mantenimiento` int NOT NULL AUTO_INCREMENT,
  `id_solicitud` int,
  `id_servicio_requerido` int,
  `id_activo` int,
  PRIMARY KEY (`id_servicio_de_mantenimiento`),
  CONSTRAINT `pk_id_serv_de_man_x_solicitud` FOREIGN KEY (`id_solicitud`) REFERENCES `sol_solicitud`(`id_solicitud`)
);

CREATE TABLE `sector` (
  `id_sector` int NOT NULL AUTO_INCREMENT,
  `nombre_sector` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_sector`)
);

CREATE TABLE `sol_servicio_de_ingenieria` (
  `id_servicio_de_ingenieria` int NOT NULL AUTO_INCREMENT,
  `id_solicitud` int,
  `id_sector` int,
  `id_activo` int,
  PRIMARY KEY (`id_servicio_de_ingenieria`),
  CONSTRAINT `pk_id_serv_de_ing_x_solicitud` FOREIGN KEY (`id_solicitud`) REFERENCES `sol_solicitud`(`id_solicitud`)
);

CREATE TABLE `sol_requerimiento_de_ingenieria` (
  `id_requerimiento_de_ingenieria` int NOT NULL AUTO_INCREMENT,
  `id_solicitud` int,
  `id_sector` int,
  PRIMARY KEY (`id_requerimiento_de_ingenieria`),
  CONSTRAINT `pk_id_req_de_ing_x_solicitud` FOREIGN KEY (`id_solicitud`) REFERENCES `sol_solicitud`(`id_solicitud`)
);

CREATE TABLE `sol_propuesta_de_mejora` (
  `id_propuesta_de_mejora` int NOT NULL AUTO_INCREMENT,
  `id_solicitud` int,
  `nombre_emisor` varchar(100),
  `id_responsabilidad` int,
  `id_sector` int,
  `id_activo` int,
  `titulo_propuesta` varchar(100) DEFAULT NULL,
  `objetivo_propuesta` varchar(500) DEFAULT NULL,
  `descripcion_propuesta` varchar(500) DEFAULT NULL,
  `analisis_propuesta` varchar(500) DEFAULT NULL,
  `beneficio_propuesta` varchar(500) DEFAULT NULL,
  `problema_propuesta` varchar(500) DEFAULT NULL,
  `evaluacion_propuesta` varchar(500) DEFAULT NULL,
  `v_tecnica` int DEFAULT NULL,
  `v_economica` int DEFAULT NULL,
  `v_temporal` int DEFAULT NULL,
  `v_total` int DEFAULT NULL,
  `necesidad` int DEFAULT NULL,
  `calificacion` int DEFAULT NULL,
  `interes` int DEFAULT NULL,
  PRIMARY KEY (`id_propuesta_de_mejora`),
  CONSTRAINT `pk_id_prop_de_mejora_x_solicitud` FOREIGN KEY (`id_solicitud`) REFERENCES `sol_solicitud`(`id_solicitud`)
);

CREATE TABLE `sol_archivo_solicitud` (
  `id_archivo_solicitud` int NOT NULL AUTO_INCREMENT,
  `id_solicitud` int NOT NULL,
  `nombre_archivo` varchar(250),
  `ruta` varchar(500),
  PRIMARY KEY (`id_archivo_solicitud`),
  CONSTRAINT `pk_id_archivo_x_solicitud` FOREIGN KEY (`id_solicitud`) REFERENCES `sol_solicitud`(`id_solicitud`)
);
-- --------------------------------------------------

CREATE TABLE `tipo_servicio` (
  `id_tipo_servicio` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_servicio` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_servicio`)
);

CREATE TABLE `subtipo_servicio` (
  `id_subtipo_servicio` int NOT NULL AUTO_INCREMENT,
  `nombre_subtipo_servicio` varchar(50) DEFAULT NULL,
  `id_tipo_servicio` int,
  CONSTRAINT `pk_id_subtipo_servicio_x_tipo_servicio` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tipo_servicio`(`id_tipo_servicio`),
  PRIMARY KEY (`id_subtipo_servicio`)
);

CREATE TABLE `tipo_proyecto` (
  `id_tipo_proyecto` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_proyecto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_proyecto`)
);

CREATE TABLE `estado` (
  `id_estado` int NOT NULL,
  `nombre_estado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
);

CREATE TABLE `estado_mecanizado` (
  `id_estado_mecanizado` int NOT NULL,
  `nombre_estado_mecanizado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_mecanizado`)
);

CREATE TABLE `estado_manufactura` (
  `id_estado_manufactura` int NOT NULL,
  `nombre_estado_manufactura` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_manufactura`)
);

CREATE TABLE `puesto_empleado` (
  `id_puesto_empleado` int NOT NULL AUTO_INCREMENT,
  `titulo_puesto_empleado` varchar(150) NOT NULL,
  `costo_hora` decimal(10,2),
  PRIMARY KEY (`id_puesto_empleado`)
);

CREATE TABLE `empleado` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `nombre_empleado` varchar(150) NOT NULL,
  `email_empleado` varchar(50),
  `telefono_empleado` varchar(50),
  `id_puesto_empleado` int,
  `id_sector` int,
  `costo_hora` decimal(10,2),
  `user_id` bigInt,
  `esta_actvo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id_empleado`),
  CONSTRAINT `pk_id_empleado_x_puesto` FOREIGN KEY (`id_puesto_empleado`) REFERENCES `puesto_empleado`(`id_puesto_empleado`),
  CONSTRAINT `pk_id_empleado_x_sector` FOREIGN KEY (`id_sector`) REFERENCES `sector`(`id_sector`)
);

CREATE TABLE `rol_empleado` (
  `id_rol_empleado` int NOT NULL AUTO_INCREMENT,
  `nombre_rol_empleado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_rol_empleado`)
);

CREATE TABLE `responsabilidad` (
  `id_responsabilidad` int NOT NULL AUTO_INCREMENT,
  `id_empleado` int NOT NULL,
  `id_rol_empleado` int NOT NULL,
  PRIMARY KEY (`id_responsabilidad`, `id_empleado`, `id_rol_empleado`),
  CONSTRAINT `pk_id_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleado`(`id_empleado`),
  CONSTRAINT `pk_id_rol_empleado` FOREIGN KEY (`id_rol_empleado`) REFERENCES `rol_empleado`(`id_rol_empleado`)
);

-- revisar
CREATE TABLE `servicio` (
  `id_servicio` int NOT NULL AUTO_INCREMENT,
  `codigo_servicio` varchar(50) DEFAULT NULL,
  `nombre_servicio` varchar(150) DEFAULT NULL,
  `fecha_inicio` date,
  `id_responsabilidad` int,
  `id_subtipo_servicio` int,
  `prioridad_servicio` int,
  `id_activo` int,
  PRIMARY KEY (`id_servicio`),
  CONSTRAINT `pk_id_servicio_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_servicio_x_subtipo_servicio` FOREIGN KEY (`id_subtipo_servicio`) REFERENCES `subtipo_servicio`(`id_subtipo_servicio`)
);
-- -----------------------//
CREATE TABLE `operacion` (
  `id_operacion` int NOT NULL AUTO_INCREMENT,
  `nombre_operacion` varchar(100),
  PRIMARY KEY (`id_operacion`)
);

CREATE TABLE `tipo_maquinaria` (
  `id_tipo_maquinaria` int NOT NULL AUTO_INCREMENT,
  `tipo_maquinaria` varchar(100),
  PRIMARY KEY (`id_tipo_maquinaria`)
);

CREATE TABLE `maquinaria` (
  `id_maquinaria` int NOT NULL AUTO_INCREMENT,
  `codigo_maquinaria` varchar(50) DEFAULT NULL,
  `alias_maquinaria` varchar(50) DEFAULT NULL,
  `descripcion_maquinaria` varchar(300),
  `id_sector` int,
  `id_tipo_maquinaria` int,
  PRIMARY KEY (`id_maquinaria`),
  CONSTRAINT `pk_id_maquinaria_x_tipo_maquinaria` FOREIGN KEY (`id_tipo_maquinaria`) REFERENCES `tipo_maquinaria`(`id_tipo_maquinaria`)
);

CREATE TABLE `ope_x_maq` (
  `id_ope_x_maq` int NOT NULL AUTO_INCREMENT,
  `id_maquinaria` int,
  `id_operacion` int,
  PRIMARY KEY (`id_ope_x_maq`),
  CONSTRAINT `pk_ope_x_maq_x_maquinaria` FOREIGN KEY (`id_maquinaria`) REFERENCES `maquinaria`(`id_maquinaria`),
  CONSTRAINT `pk_ope_x_maq_x_operacion` FOREIGN KEY (`id_operacion`) REFERENCES `operacion`(`id_operacion`)
);

CREATE TABLE `emp_x_maq` (
  `id_emp_x_maq` int NOT NULL AUTO_INCREMENT,
  `id_maquinaria` int,
  `id_empleado` int,
  PRIMARY KEY (`id_emp_x_maq`),
  CONSTRAINT `pk_emp_x_maq_x_maquinaria` FOREIGN KEY (`id_maquinaria`) REFERENCES `maquinaria`(`id_maquinaria`),
  CONSTRAINT `pk_emp_x_maq_x_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleado`(`id_empleado`)
);

CREATE TABLE `etapa` (
  `id_etapa` int NOT NULL AUTO_INCREMENT,
  `descripcion_etapa` varchar(50) DEFAULT NULL,
  `fecha_inicio` date,
  `id_servicio` int,
  `id_responsabilidad` int,
  PRIMARY KEY (`id_etapa`),
  CONSTRAINT `pk_id_etapaxpy_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicio`(`id_servicio`),
  CONSTRAINT `pk_id_etapaxres_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`)
);

CREATE TABLE `actualizacion` (
  `id_actualizacion` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) DEFAULT NULL,
  `fecha_limite` date,
  `fecha_carga` datetime,
  `id_estado` int,
  `id_responsabilidad` int,
  PRIMARY KEY (`id_actualizacion`),
  CONSTRAINT `pk_actualizacion_id_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_actualizacion_x_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`)
);

CREATE TABLE `actualizacion_servicio` (
  `id_actualizacion_servicio` int NOT NULL AUTO_INCREMENT,
  `id_actualizacion` int,
  `id_servicio` int,
  PRIMARY KEY (`id_actualizacion_servicio`),
  CONSTRAINT `pk_id_actualizacion_servicio_x_actualizacion` FOREIGN KEY (`id_actualizacion`) REFERENCES `actualizacion`(`id_actualizacion`),
  CONSTRAINT `pk_id_actualizacion_servicio_x_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicio`(`id_servicio`)
);

CREATE TABLE `actualizacion_etapa` (
  `id_actualizacion_etapa` int NOT NULL AUTO_INCREMENT,
  `id_actualizacion` int,
  `id_etapa` int,
  PRIMARY KEY (`id_actualizacion_etapa`),
  CONSTRAINT `pk_id_actualizacion_etapa_x_actualizacion` FOREIGN KEY (`id_actualizacion`) REFERENCES `actualizacion`(`id_actualizacion`),
  CONSTRAINT `pk_id_actualizacion_etapa_x_etapa` FOREIGN KEY (`id_etapa`) REFERENCES `etapa`(`id_etapa`)
);

CREATE TABLE `actualizacion_orden` (
  `id_actualizacion_orden` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) DEFAULT NULL,
  `fecha_limite` date,
  `fecha_carga` datetime,
  `id_responsabilidad` int,
  PRIMARY KEY (`id_actualizacion_orden`),
  CONSTRAINT `pk_actualizacion_ord_id_res` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`)
);

CREATE TABLE `actualizacion_orden_man` (
  `id_actualizacion_orden_man` int NOT NULL AUTO_INCREMENT,
  `id_actualizacion_orden` int,
  `id_orden_manufactura` int,
  `id_estado_manufactura` int,
  PRIMARY KEY (`id_actualizacion_orden_man`),
  CONSTRAINT `pk_id_actualizacion_ord_man_x_actualizacion` FOREIGN KEY (`id_actualizacion_orden`) REFERENCES `actualizacion_orden`(`id_actualizacion_orden`),
  CONSTRAINT `pk_id_actualizacion_ord_man_x_ord_man` FOREIGN KEY (`id_orden_manufactura`) REFERENCES `orden_manufactura`(`id_orden_manufactura`),
  CONSTRAINT `pk_id_actualizacion_ord_man_x_estado` FOREIGN KEY (`id_estado_manufactura`) REFERENCES `estado_manufactura`(`id_estado_manufactura`)
);

CREATE TABLE `actualizacion_orden_mec` (
  `id_actualizacion_orden_mec` int NOT NULL AUTO_INCREMENT,
  `id_actualizacion_orden` int,
  `id_orden_mecanizado` int,
  `id_estado_mecanizado` int,
  PRIMARY KEY (`id_actualizacion_orden_mec`),
  CONSTRAINT `pk_id_actualizacion_ord_mec_x_actualizacion` FOREIGN KEY (`id_actualizacion_orden`) REFERENCES `actualizacion_orden`(`id_actualizacion_orden`),
  CONSTRAINT `pk_id_actualizacion_ord_mec_x_ord_mec` FOREIGN KEY (`id_orden_mecanizado`) REFERENCES `orden_mecanizado`(`id_orden_mecanizado`),
  CONSTRAINT `pk_id_actualizacion_ord_mec_x_estado` FOREIGN KEY (`id_estado_mecanizado`) REFERENCES `estado_mecanizado`(`id_estado_mecanizado`)
);

CREATE TABLE `orden`(
  `id_orden` int NOT NULL AUTO_INCREMENT,
  `nombre_orden` varchar(50),
  `fecha_inicio` date,
  `duracion_estimada` time,
  `id_etapa` int,
  `costo_estimado` DECIMAL(10, 2),
  `observaciones` varchar(500),
  PRIMARY KEY(`id_orden`),
  CONSTRAINT `pk_id_orden_x_etapa` FOREIGN KEY (`id_etapa`) REFERENCES `etapa`(`id_etapa`)
);

CREATE TABLE `responsabilidad_orden`(
  `id_responsabilidad_orden` int NOT NULL AUTO_INCREMENT,
  `id_responsabilidad` int,
  `id_orden` int,
  PRIMARY KEY(`id_responsabilidad_orden`),
  CONSTRAINT `pk_id_resxorden_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_resxorden_x_orden` FOREIGN KEY (`id_orden`) REFERENCES `orden`(`id_orden`)
);

CREATE TABLE `parte`(
  `id_parte` int NOT NULL AUTO_INCREMENT,
  `observaciones` varchar(500),
  `fecha` date NOT NULL,
  `fecha_limite` date,
  `fecha_carga` datetime NOT NULL,
  `horas` time NOT NULL,
  `costo` decimal(10,2),
  `id_orden` int,
  `id_responsabilidad` int,
  PRIMARY KEY(`id_parte`),
  CONSTRAINT `pk_id_parte_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_parte_x_orden` FOREIGN KEY (`id_orden`) REFERENCES `orden`(`id_orden`)
);

CREATE TABLE `tipo_orden_trabajo` (
  `id_tipo_orden_trabajo` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_orden_trabajo` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_orden_trabajo`)
);

CREATE TABLE `orden_trabajo` (
  `id_orden_trabajo` int NOT NULL AUTO_INCREMENT,
  `id_tipo_orden_trabajo` int,
  `id_orden` int,
  PRIMARY KEY (`id_orden_trabajo`),
  CONSTRAINT `pk_id_orden_trabajo_x_orden` FOREIGN KEY (`id_orden`) REFERENCES `orden`(`id_orden`),
  CONSTRAINT `pk_id_orden_trabajo_x_tipo_orden_trabajo` FOREIGN KEY (`id_tipo_orden_trabajo`) REFERENCES `tipo_orden_trabajo`(`id_tipo_orden_trabajo`)
);

CREATE TABLE `parte_trabajo` (
  `id_parte_trabajo` int NOT NULL AUTO_INCREMENT,
  `id_estado` int,
  `id_parte` int,
  PRIMARY KEY (`id_parte_trabajo`),
  CONSTRAINT `pk_id_parte_trabajo_x_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_parte_trabajo_x_parte` FOREIGN KEY (`id_parte`) REFERENCES `parte`(`id_parte`)
);

CREATE TABLE `orden_manufactura` (
  `id_orden_manufactura` int NOT NULL AUTO_INCREMENT,
  `revision` int,
  `cantidad` int,
  `ruta_plano` varchar(500) DEFAULT NULL,
  `id_orden` int,
  PRIMARY KEY (`id_orden_manufactura`),
  CONSTRAINT `pk_id_orden_manufactura_x_orden` FOREIGN KEY (`id_orden`) REFERENCES `orden`(`id_orden`)
);

CREATE TABLE `parte_manufactura` (
  `id_parte_manufactura` int NOT NULL AUTO_INCREMENT,
  `id_estado_manufactura` int,
  `id_parte` int,
  PRIMARY KEY (`id_parte_manufactura`),
  CONSTRAINT `pk_id_parte_manufactura_x_estado_manufactura` FOREIGN KEY (`id_estado_manufactura`) REFERENCES `estado_manufactura`(`id_estado_manufactura`),
  CONSTRAINT `pk_id_parte_manufactura_x_parte` FOREIGN KEY (`id_parte`) REFERENCES `parte`(`id_parte`)
);

CREATE TABLE `orden_mecanizado` (
  `id_orden_mecanizado` int NOT NULL AUTO_INCREMENT,
  `revision` int,
  `cantidad` int,
  `ruta_pieza` varchar(500) DEFAULT NULL,
  `id_orden` int,
  `id_orden_manufactura` int,
  PRIMARY KEY (`id_orden_mecanizado`),
  CONSTRAINT `pk_id_orden_mecanizado_x_orden` FOREIGN KEY (`id_orden`) REFERENCES `orden`(`id_orden`)
);

-- OLD
CREATE TABLE `parte_mecanizado` (
  `id_parte_mecanizado` int NOT NULL AUTO_INCREMENT,
  `id_estado_mecanizado` int,
  `id_parte` int,
  PRIMARY KEY (`id_parte_mecanizado`),
  CONSTRAINT `pk_id_parte_mecanizado_x_estado_mecanizado` FOREIGN KEY (`id_estado_mecanizado`) REFERENCES `estado_mecanizado`(`id_estado_mecanizado`),
  CONSTRAINT `pk_id_parte_mecanizado_x_parte` FOREIGN KEY (`id_parte`) REFERENCES `parte`(`id_parte`)
);

-- -----

CREATE TABLE `estado_hdr` (
  `id_estado_hdr` int NOT NULL AUTO_INCREMENT,
  `nombre_estado_hdr` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_hdr`)
);

CREATE TABLE `hoja_de_ruta` (
  `id_hoja_de_ruta` int NOT NULL AUTO_INCREMENT,
  `fecha_carga` datetime,
  `observaciones` varchar(500),
  `ubicacion` varchar(100),
  `cantidad` int,
  `id_responsabilidad` int,
  `id_orden_mecanizado` int,
  `ruta` varchar(500),
  PRIMARY KEY (`id_hoja_de_ruta`),
  CONSTRAINT `pk_hoja_de_ruta_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_hoja_de_ruta_x_orden_mec` FOREIGN KEY (`id_orden_mecanizado`) REFERENCES `orden_mecanizado`(`id_orden_mecanizado`)
);

CREATE TABLE `archivo_hdr` (
  `id_archivo_hdr` int NOT NULL AUTO_INCREMENT,
  `id_hoja_de_ruta` int NOT NULL,
  `nombre_archivo` varchar(250),
  `ruta` varchar(500),
  PRIMARY KEY (`id_archivo_hdr`),
  CONSTRAINT `pk_id_archivo_x_hdr` FOREIGN KEY (`id_hoja_de_ruta`) REFERENCES `hoja_de_ruta`(`id_hoja_de_ruta`)
);

CREATE TABLE `operaciones_de_hdr` (
  `id_ope_de_hdr` int NOT NULL AUTO_INCREMENT,
  `id_hoja_de_ruta` int,
  `prioridad` int,
  `numero` int,
  `fecha_carga` datetime,
  `fecha` date,
  `id_maquinaria` int NULL,
  `id_operacion` int,
  `ruta_cam` varchar(100),
  `activo` boolean,
  PRIMARY KEY (`id_ope_de_hdr`),
  CONSTRAINT `pk_ope_de_hdr_x_maquinaria` FOREIGN KEY (`id_maquinaria`) REFERENCES `maquinaria`(`id_maquinaria`),
  CONSTRAINT `pk_ope_de_hdr_x_operacion` FOREIGN KEY (`id_operacion`) REFERENCES `operacion`(`id_operacion`),
  CONSTRAINT `pk_ope_de_hdr_x_hdr` FOREIGN KEY (`id_hoja_de_ruta`) REFERENCES `hoja_de_ruta`(`id_hoja_de_ruta`)
);

CREATE TABLE `parte_ope_hdr` (
  `id_parte_ope_hdr` int NOT NULL AUTO_INCREMENT,
  `id_ope_de_hdr` int,
  `fecha_carga` datetime,
  `fecha` date,
  `observaciones` varchar(500),
  `id_responsabilidad` int,
  `horas` time,
  `horas_maquina` time,
  `medidas` boolean,
  `id_estado_hdr` int,
  PRIMARY KEY (`id_parte_ope_hdr`),
  CONSTRAINT `pk_parte_ope_hdr_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_parte_ope_hdr_x_ope_hdr` FOREIGN KEY (`id_ope_de_hdr`) REFERENCES `operaciones_de_hdr`(`id_ope_de_hdr`),
  CONSTRAINT `pk_parte_ope_hdr_x_est_hdr` FOREIGN KEY (`id_estado_hdr`) REFERENCES `estado_hdr`(`id_estado_hdr`)
);


CREATE TABLE `parte_mecanizado_x_maquinaria`(
  `id_parte_mecanizado_x_maquinaria` int NOT NULL AUTO_INCREMENT,
  `id_parte_mecanizado` int,
  `id_maquinaria` int,
  `horas_maquina` time,
  PRIMARY KEY(`id_parte_mecanizado_x_maquinaria`),
  CONSTRAINT `pk_id_parte_mec_maq_x_parte_mecanizado` FOREIGN KEY (`id_parte_mecanizado`) REFERENCES `parte_mecanizado`(`id_parte_mecanizado`),
  CONSTRAINT `pk_id_parte_mec_maq_x_parte_maquinaria` FOREIGN KEY (`id_maquinaria`) REFERENCES `maquinaria`(`id_maquinaria`)
);

CREATE TABLE `tipo_orden_mantenimiento` (
  `id_tipo_orden_mantenimiento` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_orden_mantenimiento` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_orden_mantenimiento`)
);

CREATE TABLE `orden_mantenimiento` (
  `id_orden_mantenimiento` int NOT NULL AUTO_INCREMENT,
  `id_orden` int,
  `id_tipo_orden_mantenimiento` int,
  PRIMARY KEY (`id_orden_mantenimiento`),
  CONSTRAINT `pk_id__orden_mantenimiento_x_orden` FOREIGN KEY (`id_orden`) REFERENCES `orden`(`id_orden`),
  CONSTRAINT `pk_id__orden_mantenimiento_x_tipo_orden_mantenimiento` FOREIGN KEY (`id_tipo_orden_mantenimiento`) REFERENCES `tipo_orden_mantenimiento`(`id_tipo_orden_mantenimiento`)
);

CREATE TABLE `parte_mantenimiento` (
  `id_parte_mantenimiento` int NOT NULL AUTO_INCREMENT,
  `engrase` boolean,
  `prueba_de_agua` boolean,
  `prueba_electrica` boolean,
  `id_estado` int,
  `id_parte` int,
  PRIMARY KEY (`id_parte_mantenimiento`),
  CONSTRAINT `pk_id_pm_x_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_pm_x_parte` FOREIGN KEY (`id_parte`) REFERENCES `parte`(`id_parte`)
);

-- CREATE TABLE `parte_mecanizado_x_maquinaria` (
--  `id_parte_mec_x_maq` int NOT NULL AUTO_INCREMENT,
--  `id_parte_mecanizado` int,
--  `id_maquinaria` boolean,
--  `horas_maquina` time,
--  PRIMARY KEY (`id_parte_mec_x_maq`),
--  CONSTRAINT `pk_id_parte_mec_x_maq_x_parte_mec` FOREIGN KEY (`id_parte_mecanizado`) REFERENCES `parte_mecanizado`(`id_parte_mecanizado`),
--  CONSTRAINT `pk_id_parte_mec_x_maq_x_maq` FOREIGN KEY (`id_maquinaria`) REFERENCES `maquinaria`(`id_maquinaria`)
-- );

CREATE TABLE `parte_mantenimiento_x_maquinaria` (
  `id_parte_man_x_maq` int NOT NULL AUTO_INCREMENT,
  `id_parte_mantenimiento` int,
  `id_maquinaria` int,
  `horas_maquina` time,
  PRIMARY KEY (`id_parte_man_x_maq`),
  CONSTRAINT `pk_id_parte_man_x_maq_x_parte_man` FOREIGN KEY (`id_parte_mantenimiento`) REFERENCES `parte_mantenimiento`(`id_parte_mantenimiento`),
  CONSTRAINT `pk_id_parte_man_x_maq_x_maq` FOREIGN KEY (`id_maquinaria`) REFERENCES `maquinaria`(`id_maquinaria`)
);

CREATE TABLE `cambio_de_prioridad`(
  `id_cambio_de_prioridad` int NOT NULL AUTO_INCREMENT,
  `motivo` varchar(500),
  `prioridad_ant` int,
  `prioridad_nue` int,
  `fecha_carga` datetime,
  `id_empleado` int,
  `id_servicio` int,
  PRIMARY KEY(`id_cambio_de_prioridad`)
);

CREATE TABLE `tipo_relacion_gantt`(
  `id_tipo_relacion_gantt` int NOT NULL AUTO_INCREMENT,
  `nombre_relacion_gantt` varchar(50),
  PRIMARY KEY(`id_tipo_relacion_gantt`)
);

CREATE TABLE `orden_gantt`(
  `id_orden_gantt` int NOT NULL AUTO_INCREMENT,
  `id_tipo_relacion_gantt` int,
  `id_orden_anterior` int,
  `id_orden_siguiente` int,
  PRIMARY KEY(`id_orden_gantt`),
  CONSTRAINT `id_orden_gantt_x_id_tipo_relacion_gantt` FOREIGN KEY (`id_tipo_relacion_gantt`) REFERENCES `tipo_relacion_gantt`(`id_tipo_relacion_gantt`)
);

CREATE TABLE `prefijo_proyecto`(
  `id_prefijo_proyecto` int NOT NULL AUTO_INCREMENT,
  `nombre_prefijo_proyecto` varchar(100),
  `descripcion_prefijo_proyecto` varchar(500),
  PRIMARY KEY(`id_prefijo_proyecto`)
);

CREATE TABLE `doc_documento`(
  `id_documento` int NOT NULL AUTO_INCREMENT,
  `nombre_documento` varchar(100),
  `descripcion_documento` varchar(500),
  `ubicacion_documento` varchar(200),
  PRIMARY KEY(`id_documento`)
);

CREATE TABLE `servicio_info`(
  `id_servicio` int NOT NULL,
  `tot_ord` int NOT NULL,
  `tot_ord_completa` int NOT NULL,
  `progreso` int NOT NULL,
  PRIMARY KEY(`id_servicio`)
);

CREATE TABLE `log_parte`(
  `id_log_parte` int AUTO_INCREMENT,
  `id_parte` int not null,
  `id_responsabilidad` int,
  `observaciones` varchar(500),
  `fecha` date not null,
  `fecha_limite` date not null,
  `fecha_carga` datetime not null,
  `horas` time not null,
  `estado` varchar(100),
  `id_maquinaria` int,
  `horas_maquina` time,
  `responsable_cambio` int not null,
  PRIMARY KEY(`id_log_parte`),
  CONSTRAINT `id_log_parte_x_id_parte` FOREIGN KEY (`id_parte`) REFERENCES `parte`(`id_parte`)
);

CREATE TABLE `em_notificacion` (
    `id_em_notificacion` INT AUTO_INCREMENT,
    `nombre_em_notificacion` VARCHAR(255) NOT NULL,
    `descripcion_em_notificacion` VARCHAR(500),
    primary key(`id_em_notificacion`)
);

CREATE TABLE `em_not_x_empleado` (
    `id_not_x_empleado` INT AUTO_INCREMENT,
    `id_em_notificacion` INT,
    `id_empleado` INT,
    PRIMARY KEY (`id_not_x_empleado`),
    CONSTRAINT `pk_id_em_not_emp_x_emp` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
    CONSTRAINT `pk_id_em_not_emp_x_em_noti` FOREIGN KEY (`id_em_notificacion`) REFERENCES `em_notificacion` (`id_em_notificacion`)
);

CREATE TABLE `not_notificacion` (
    `id_notificacion` INT AUTO_INCREMENT,
    `user_id` bigint unsigned,
    `id_not_cuerpo` int,
    `tipo` VARCHAR(50),
    `leido` boolean default 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`id_notificacion`),
    CONSTRAINT `pk_id_not_x_us` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    CONSTRAINT `pk_id_not_x_not_tmp` FOREIGN KEY (`id_not_cuerpo`) REFERENCES `not_notificacion_cuerpo`(`id_not_cuerpo`)
);

CREATE TABLE `not_notificacion_cuerpo` (
    `id_not_cuerpo` INT AUTO_INCREMENT,
    `titulo` VARCHAR(100),
    `mensaje` VARCHAR(255),
    `url` VARCHAR(300),
    primary key(`id_not_cuerpo`)
);

CREATE TABLE `og_organigrama` (
    `id_organigrama` INT AUTO_INCREMENT,
    `id_empleado` INT,
    `id_supervisor_directo` INT,
    PRIMARY KEY (`id_organigrama`),
    CONSTRAINT `pk_id_og_x_emp` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
    CONSTRAINT `pk_id_og_x_supervisor` FOREIGN KEY (`id_supervisor_directo`) REFERENCES `empleado` (`id_empleado`)
);
--------------------------------------------------
-- Insert iniciales
INSERT INTO tipo_orden_trabajo (nombre_tipo_orden_trabajo)
VALUES
    ('Producto'),
    ('Herramental'),
    ('Procesos'),
    ('Gestion'),
    ('Externo');

INSERT INTO tipo_orden_mantenimiento (nombre_tipo_orden_mantenimiento)
VALUES
    ('Cambio de configuracion y mantenimiento'),
    ('Mantenimiento'),
    ('Almacenaje'),
    ('Reparacion');
  
INSERT INTO sector (nombre_sector)
VALUES
    ('Comercial'),
    ('Calidad'),
    ('Mantenimiento'),
    ('Armado'),
    ('Compras'),
    ('Depósito de insumos'),
    ('Expedición'),
    ('I+D'),
    ('Ingeniería'),
    ('Inyección'),
    ('Marketing'),
    ('Matricería'),
    ('Mecánica'),
    ('Pañol'),
    ('Producción'),
    ('RRHH'),
    ('Sistemas');

-- insert into sector (nombre_sector) values ('Armado'), ('Compras'), ('Depósito de insumos'), ('Expedición'), ('I+D'), ('Ingeniería'), ('Inyección'), ('Marketing'), ('Matricería'), ('Mecánica'), ('Pañol'), ('Producción'), ('RRHH'), ('Sistemas');

INSERT INTO sol_prioridad_solicitud (nombre_prioridad_solicitud)
VALUES
    ('Baja'),
    ('Programable'),
    ('Urgente');

INSERT INTO sol_estado_solicitud (id_estado_solicitud, nombre_estado_solicitud)
VALUES
    (1, 'En espera'),
    (2, 'Aceptado'),
    (3, 'Rechazado');

INSERT INTO puesto_empleado (titulo_puesto_empleado, costo_hora)
VALUES
    ('Diseñador de producto', 13.45),
    ('Asistente de ingenieria', 45.98);

INSERT INTO tipo_servicio (nombre_tipo_servicio)
VALUES
    ('Proyecto'),
    ('Servicio de ingenieria'),
    ('Servicio de mantenimiento');

INSERT INTO subtipo_servicio (nombre_subtipo_servicio, id_tipo_servicio)
VALUES
    ('Macroproyecto', 1),
    ('Microproyecto', 1),
    ('Modificacion', 1),
    ('Tarea', 1),
    ('Servicio de ingenieria', 2),
    ('Servicio de mantenimiento', 3);

-- INSERT INTO tipo_servicio (nombre_tipo_servicio)
-- VALUES
   -- ('Asistencia técnica'),
   -- ('Capacitación'),
   -- ('Desarrollo de herramental'),
   -- ('Desarrollo de proceso'),
   -- ('Desarrollo de producto'),
   -- ('Evaluación de producto'),
   -- ('Evaluación de propuesta de mejora continua'),
   -- ('Generación de documentación'),
   -- ('Gestión de instalación industrial'),
   -- ('Gestión de sistematización'),
   -- ('Gestión empresarial'),
   -- ('Investigación de producto'),
   -- ('Mantenimiento correctivo técnico'),
   -- ('Mantenimiento preventivo técnico'),
   -- ('Modificación de herramental'),
   -- ('Modificación de proceso'),
   -- ('Modificación de producto'),
   -- ('Puesta a punto técnica');

INSERT INTO rol_empleado(nombre_rol_empleado)
VALUES
  ('Lider'),
  ('Responsable'),
  ('Supervisor');

-- INSERT INTO prioridad(nombre_prioridad)
-- VALUES
--  ('Baja'),
--  ('Media'),
--  ('Alta');

INSERT INTO estado(id_estado, nombre_estado)
VALUES
  (1, 'Continua'),
  (2, 'En proceso'),
  (3, 'Espera'),
  (4, 'Pausa'),
  (5, 'Externo'),
  (6, 'Programado'),
  (7, 'Revisar'),
  (8, 'Problema'),
  (9, 'Completo'),
  (10, 'Cancelado');

INSERT INTO estado_mecanizado(id_estado_mecanizado, nombre_estado_mecanizado)
VALUES
  (1, 'Planos entregados'),
  (2, 'Material encargado'),
  (3, 'Material preparado'),
  (4, 'Mecanizado completo'),
  (5, 'Temple'),
  (6, 'Pieza finalizada'),
  (7, 'Cancelado');

INSERT INTO estado_manufactura(id_estado_manufactura, nombre_estado_manufactura)
VALUES
  (1, 'Orden creada'),
  (2, 'Piezas en fabricacion'),
  (3, 'Piezas listas'),
  (4, 'Ajuste listo'),
  (5, 'Ensamble listo'),
  (6, 'Cancelado');

INSERT INTO tipo_relacion_gantt(nombre_relacion_gantt)
VALUES
  ('inicio - inicio'),
  ('inicio - fin'),
  ('fin - fin');

-- CREATE VIEW vw_servicio AS
-- select se.id_servicio, se.prioridad_servicio, se.codigo_servicio, se.nombre_servicio, stb.id_subtipo_servicio, stb.nombre_subtipo_servicio, tb.id_tipo_servicio, tb.nombre_tipo_servicio, se.fecha_inicio, emp.id_empleado, emp.nombre_empleado as lider, act_se.id_actualizacion, act.fecha_limite, est.id_estado, est.nombre_estado    
-- inner join responsabilidad as res on se.id_responsabilidad = res.id_responsabilidad
--    inner join empleado as emp on res.id_empleado = emp.id_empleado
--    inner join (select act_s.id_actualizacion_servicio, max(act_s.id_actualizacion) as id_actualizacion, act_s.id_servicio 
--			          from actualizacion_servicio as act_s 
--                group by act_s.id_servicio) as act_se on act_se.id_servicio = se.id_servicio
--    inner join actualizacion as act on act.id_actualizacion=act_se.id_actualizacion
--    inner join estado as est on act.id_estado=est.id_estado;





DELIMITER //

CREATE PROCEDURE Act_info_servicio ()
BEGIN
    DECLARE vtotOrdTra INT;
    DECLARE vtotOrdMan INT;
    DECLARE vtotOrdMec INT;
    DECLARE vtotOrdTraCan INT;
    DECLARE vtotOrdManCan INT;
    DECLARE vtotOrdMecCan INT;
    DECLARE vTotCompleto INT;
    DECLARE vTotCancelado INT;
    DECLARE vTotal INT;
    DECLARE vProgreso INT;
    DECLARE x INT;
    DECLARE e INT;
    DECLARE b INT DEFAULT 0;
    DECLARE cur1 CURSOR FOR SELECT id_servicio FROM servicio;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET b = 1;
    
    
    OPEN cur1;
    
    read_loop: LOOP
        FETCH cur1 INTO x;
        
		IF b THEN
		 LEAVE read_loop;
		END IF;
        
        SELECT COUNT(id_servicio) INTO e FROM servicio_info WHERE id_servicio = x;
        
        SELECT TotalOrdenTrabajoCompleto(x) INTO vtotOrdTra;
        SELECT TotalOrdenMecCompleto(x) INTO vtotOrdMan;
        SELECT TotalOrdenManCompleto(x) INTO vtotOrdMec;
        
        SELECT TotalOrdenTrabajoCancelado(x) INTO vtotOrdTraCan;
        SELECT TotalOrdenMecCancelado(x) INTO vtotOrdManCan;
        SELECT TotalOrdenManCancelado(x) INTO vtotOrdMecCan;
        
        SET vTotCompleto = vtotOrdTra + vtotOrdMan + vtotOrdMec;
        SET vTotCancelado = vtotOrdTraCan + vtotOrdManCan + vtotOrdMecCan;
        
        SELECT COUNT(id_orden) AS total_orden INTO vTotal FROM orden o WHERE id_etapa IN (SELECT id_etapa FROM etapa WHERE id_servicio = x);
        
        SET vTotal = vTotal - vTotCancelado;
        
        IF vTotal = 0 THEN
            SET vProgreso = 0;
        ELSE
            SET vProgreso = ROUND((vTotCompleto * 100) / vTotal);
        END IF;
        
        IF e = 0 THEN
            INSERT INTO servicio_info (id_servicio, tot_ord, tot_ord_completa, progreso) VALUES (x, vTotal, vTotCompleto, vProgreso);
        ELSE
            UPDATE servicio_info SET tot_ord = vTotal, tot_ord_completa = vTotCompleto, progreso = vProgreso WHERE id_servicio = x;
        END IF;
        
    END LOOP read_loop;
    
    CLOSE cur1;
END;
//
DELIMITER ;

DELIMITER //

CREATE PROCEDURE ObtenerTotalHorasServicio(IN usuario INT, IN fecha_d DATE, IN fecha_h DATE)
BEGIN
    DECLARE vTotHo INT DEFAULT 0;

    -- Calcular el total de horas
    SELECT 
        SUM(TIME_TO_SEC(p.horas)) INTO vTotHo
    FROM parte p
    INNER JOIN responsabilidad res ON res.id_responsabilidad = p.id_responsabilidad
    INNER JOIN empleado emp ON emp.id_empleado = res.id_empleado
    INNER JOIN orden o ON o.id_orden = p.id_orden
    INNER JOIN etapa et ON et.id_etapa = o.id_etapa
    INNER JOIN servicio se ON se.id_servicio = et.id_servicio
    WHERE fecha >= fecha_d and fecha <= fecha_h
      AND emp.id_empleado = usuario;

    -- Devolver todos los resultados en un solo conjunto
    SELECT 
        p.fecha_carga,
        se.id_servicio,
        se.codigo_servicio,
        TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(p.horas))), '%H:%i') AS h_total,
        emp.id_empleado AS id_responsable,
        case when ROUND((SUM(TIME_TO_SEC(p.horas)) * 100) / vTotHo) is null then 0
			else ROUND((SUM(TIME_TO_SEC(p.horas)) * 100) / vTotHo)
		end AS porcentaje,
        SEC_TO_TIME(vTotHo) as total_ac
    FROM parte p
    INNER JOIN responsabilidad res ON res.id_responsabilidad = p.id_responsabilidad
    INNER JOIN empleado emp ON emp.id_empleado = res.id_empleado
    INNER JOIN orden o ON o.id_orden = p.id_orden
    INNER JOIN etapa et ON et.id_etapa = o.id_etapa
    INNER JOIN servicio se ON se.id_servicio = et.id_servicio
    WHERE fecha >= fecha_d and fecha <= fecha_h 
      AND emp.id_empleado = usuario 
    GROUP BY se.id_servicio;
END //

DELIMITER ;



DROP TABLE parte_mantenimiento;
DROP TABLE orden_mantenimiento;
DROP TABLE parte_mecanizado_x_maquinaria;
DROP TABLE parte_mecanizado;
DROP TABLE orden_mecanizado;
DROP TABLE parte_manufactura;
DROP TABLE orden_manufactura;
DROP TABLE parte_trabajo;
DROP TABLE orden_trabajo;
DROP TABLE actualizacion_etapa;
DROP TABLE actualizacion_servicio;
DROP TABLE actualizacion;
DROP TABLE etapa;
-- DROP TABLE tipo_etapa;
DROP TABLE maquinaria;
DROP TABLE servicio;
DROP TABLE responsabilidad;
DROP TABLE rol_empleado;
DROP TABLE empleado;
DROP TABLE puesto_empleado;
DROP TABLE estado;
DROP TABLE estado_mecanizado;
-- DROP TABLE prioridad;
DROP TABLE tipo_proyecto;
DROP TABLE subtipo_servicio;
DROP TABLE tipo_servicio;
DROP TABLE propuesta_de_mejora;
DROP TABLE requerimiento_de_ingenieria;
DROP TABLE servicio_de_ingenieria;
DROP TABLE sector;
DROP TABLE servicio_de_mantenimiento;
DROP TABLE activo;
DROP TABLE servicio_requerido;
DROP TABLE solicitud;
DROP TABLE estado_solicitud;
DROP TABLE prioridad_solicitud;
DROP TABLE tipo_orden_mantenimiento;
DROP TABLE tipo_orden_trabajo;
DROP TABLE orden_gantt;
DROP TABLE tipo_relacion_gantt;