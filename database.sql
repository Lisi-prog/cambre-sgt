CREATE TABLE `prioridad_solicitud` (
  `id_prioridad_solicitud` int NOT NULL AUTO_INCREMENT,
  `nombre_prioridad_solicitud` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_prioridad_solicitud`)
);

CREATE TABLE `estado_solicitud` (
  `id_estado_solicitud` int NOT NULL AUTO_INCREMENT,
  `nombre_estado_solicitud` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_solicitud`)
);

CREATE TABLE `solicitud` (
  `id_solicitud` int NOT NULL AUTO_INCREMENT,
  `id_prioridad_solicitud` int,
  `id_estado_solicitud` int,
  `nombre_solicitante` varchar(100),
  `descripcion_solicitud` varchar(500) DEFAULT NULL,
  `fecha_carga` datetime,
  `fecha_requerida` date,
  `descripcion_urgencia` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_solicitud`)
);

CREATE TABLE `servicio_requerido` (
  `id_servicio_requerido` int NOT NULL AUTO_INCREMENT,
  `nombre_servicio_requerido` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_servicio_requerido`)
);

CREATE TABLE `activo` (
  `id_activo` int NOT NULL AUTO_INCREMENT,
  `nombre_activo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_activo`)
);

CREATE TABLE `servicio_de_mantenimiento` (
  `id_servicio_de_mantenimiento` int NOT NULL AUTO_INCREMENT,
  `id_solicitud` int,
  `id_servicio_requerido` int,
  `id_activo` int,
  PRIMARY KEY (`id_servicio_de_mantenimiento`)
);

CREATE TABLE `sector` (
  `id_sector` int NOT NULL AUTO_INCREMENT,
  `nombre_sector` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_sector`)
);

CREATE TABLE `servicio_de_ingenieria` (
  `id_servicio_de_ingenieria` int NOT NULL AUTO_INCREMENT,
  `id_solicitud` int,
  `id_empleado` int,
  `id_sector` int,
  `id_activo` int,
  PRIMARY KEY (`id_servicio_de_ingenieria`)
);

CREATE TABLE `requerimiento_de_ingenieria` (
  `id_requerimiento_de_ingenieria` int NOT NULL AUTO_INCREMENT,
  `id_solicitud` int,
  `id_empleado` int,
  `id_sector` int,
  PRIMARY KEY (`id_requerimiento_de_ingenieria`)
);

CREATE TABLE `propuesta_de_mejora` (
  `id_propuesta_de_mejora` int NOT NULL AUTO_INCREMENT,
  `id_empleado` int,
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
  `fecha_carga` datetime,
  PRIMARY KEY (`id_propuesta_de_mejora`)
);
-- --------------------------------------------------

CREATE TABLE `tipo_servicio` (
  `id_tipo_servicio` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_servicio` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_servicio`)
);

CREATE TABLE `tipo_proyecto` (
  `id_tipo_proyecto` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_proyecto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_proyecto`)
);

CREATE TABLE `prioridad` (
  `id_prioridad` int NOT NULL AUTO_INCREMENT,
  `nombre_prioridad` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_prioridad`)
);

CREATE TABLE `estado` (
  `id_estado` int NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
);

CREATE TABLE `estado_mecanizado` (
  `id_estado_mecanizado` int NOT NULL AUTO_INCREMENT,
  `nombre_estado_mecanizado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado_mecanizado`)
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
  `user_id` bigInt,
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
  `nombre_servicio` varchar(50) DEFAULT NULL,
  `fecha_inicio` date,
  `fecha_limite` date,
  `id_responsabilidad` int,
  `id_estado` int,
  `id_tipo_servicio` int,
  `id_tipo_proyecto` int,
  `id_prioridad` int,
  PRIMARY KEY (`id_servicio`),
  CONSTRAINT `pk_id_servicio_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_servicio_x_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_servicio_x_tipo_servicio` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `tipo_servicio`(`id_tipo_servicio`),
  CONSTRAINT `pk_id_servicio_x_tipo_proyecto` FOREIGN KEY (`id_tipo_proyecto`) REFERENCES `tipo_proyecto`(`id_tipo_proyecto`),
  CONSTRAINT `pk_id_servicio_x_prioridad` FOREIGN KEY (`id_prioridad`) REFERENCES `prioridad`(`id_prioridad`)
);
-- -----------------------//

CREATE TABLE `actualizacion` (
  `id_actualizacion` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `id_responsabilidad` int,
  PRIMARY KEY (`id_actualizacion`),
  CONSTRAINT `pk_actualizacion_id_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`)
);

CREATE TABLE `maquinaria` (
  `id_maquinaria` int NOT NULL AUTO_INCREMENT,
  `codigo_maquinaria` varchar(50) DEFAULT NULL,
  `alias_maquinaria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_maquinaria`)
);

CREATE TABLE `tipo_etapa` (
  `id_tipo_etapa` int NOT NULL AUTO_INCREMENT,
  `nombre_tipo_etapa` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_etapa`)
);

CREATE TABLE `etapa` (
  `id_etapa` int NOT NULL AUTO_INCREMENT,
  `nombre_etapa` varchar(50) DEFAULT NULL,
  `descripcion_etapa` varchar(50) DEFAULT NULL,
  `fecha_inicio` date,
  `fecha_limite` date,
  `id_servicio` int,
  `id_responsabilidad` int,
  `id_estado` int,
  `id_tipo_etapa` int,
  `id_actualizacion` int,
  PRIMARY KEY (`id_etapa`),
  CONSTRAINT `pk_id_etapaxpy_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicio`(`id_servicio`),
  CONSTRAINT `pk_id_etapaxres_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_etapaxest_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_etapaxte_tipo_etapa` FOREIGN KEY (`id_tipo_etapa`) REFERENCES `tipo_etapa`(`id_tipo_etapa`),
  CONSTRAINT `pk_id_etapaxact_actualizacion` FOREIGN KEY (`id_actualizacion`) REFERENCES `actualizacion`(`id_actualizacion`)
);

CREATE TABLE `orden_trabajo` (
  `id_orden_trabajo` int NOT NULL AUTO_INCREMENT,
  `nombre_orden_trabajo` varchar(50) DEFAULT NULL,
  `id_estado` int,
  `id_etapa` int,
  `id_responsabilidad` int,
  PRIMARY KEY (`id_orden_trabajo`),
  CONSTRAINT `pk_id_orden_trabajo_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_orden_trabajo_x_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_orden_trabajo_x_etapa` FOREIGN KEY (`id_etapa`) REFERENCES `etapa`(`id_etapa`)
);

CREATE TABLE `parte_trabajo` (
  `id_parte_trabajo` int NOT NULL AUTO_INCREMENT,
  `observacion` varchar(500) DEFAULT NULL,
  `fecha` date,
  `fecha_limite` date,
  `fecha_carga` date,
  `horas` time,
  `id_estado` int,
  `id_orden_trabajo` int,
  `id_responsabilidad` int,
  PRIMARY KEY (`id_parte_trabajo`),
  CONSTRAINT `pk_id_parte_trabajo_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_parte_trabajo_x_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_parte_trabajo_x_orden_trabajo` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `orden_trabajo`(`id_orden_trabajo`)
);

CREATE TABLE `orden_manufactura` (
  `id_orden_manufactura` int NOT NULL AUTO_INCREMENT,
  `revision` varchar(10) DEFAULT NULL,
  `cantidad` int,
  `fecha_inicio` date,
  `fecha_requerida` date,
  `ruta_plano` varchar(500) DEFAULT NULL,
  `observaciones` varchar(100) DEFAULT NULL,
  `id_estado` int,
  `id_etapa` int,
  `id_responsabilidad` int,
  PRIMARY KEY (`id_orden_manufactura`),
  CONSTRAINT `pk_id_orden_manufactura_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_orden_manufactura_x_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_orden_manufactura_x_etapa` FOREIGN KEY (`id_etapa`) REFERENCES `etapa`(`id_etapa`)
);

CREATE TABLE `orden_mecanizado` (
  `id_orden_mecanizado` int NOT NULL AUTO_INCREMENT,
  `revision` varchar(10) DEFAULT NULL,
  `cantidad` int,
  `fecha_inicio` date,
  `fecha_requerida` date,
  `ruta_plano` varchar(500) DEFAULT NULL,
  `observaciones` varchar(100) DEFAULT NULL,
  `id_prioridad` int,
  `id_estado_mecanizado` int,
  `id_orden_manufactura` int,
  `id_responsabilidad` int,
  PRIMARY KEY (`id_orden_mecanizado`),
  CONSTRAINT `pk_id_orden_mecanizado_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_orden_mecanizado_x_estado_mecanizado` FOREIGN KEY (`id_estado_mecanizado`) REFERENCES `estado_mecanizado`(`id_estado_mecanizado`),
  CONSTRAINT `pk_id_orden_mecanizado_x_orden_manufactura` FOREIGN KEY (`id_orden_manufactura`) REFERENCES `orden_manufactura`(`id_orden_manufactura`),
  CONSTRAINT `pk_id_orden_mecanizado_x_prioridad` FOREIGN KEY (`id_prioridad`) REFERENCES `prioridad`(`id_prioridad`)
);

CREATE TABLE `parte_mecanizado` (
  `id_parte_mecanizado` int NOT NULL AUTO_INCREMENT,
  `observacion` varchar(500) DEFAULT NULL,
  `fecha` date,
  `fecha_limite` date,
  `fecha_carga` date,
  `horas` time,
  `horas_maquina` time,
  `id_estado` int,
  `id_orden_mecanizado` int,
  `id_responsabilidad` int,
  `id_maquinaria` int,
  PRIMARY KEY (`id_parte_mecanizado`),
  CONSTRAINT `pk_id_parte_mecanizado_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_parte_mecanizado_x_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_parte_mecanizado_x_orden_mecanizado` FOREIGN KEY (`id_orden_mecanizado`) REFERENCES `orden_mecanizado`(`id_orden_mecanizado`),
  CONSTRAINT `pk_id_parte_mecanizado_x_maquinaria` FOREIGN KEY (`id_maquinaria`) REFERENCES `maquinaria`(`id_maquinaria`)
);

CREATE TABLE `orden_mantenimiento` (
  `id_orden_mantenimiento` int NOT NULL AUTO_INCREMENT,
  `nombre_orden_mantenimiento` varchar(500) DEFAULT NULL,
  `id_estado` int,
  `id_etapa` int,
  `id_responsabilidad` int,
  PRIMARY KEY (`id_orden_mantenimiento`),
  CONSTRAINT `pk_id_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_etapa` FOREIGN KEY (`id_etapa`) REFERENCES `etapa`(`id_etapa`)
);

CREATE TABLE `parte_mantenimiento` (
  `id_parte_mantenimiento` int NOT NULL AUTO_INCREMENT,
  `observacion` varchar(500) DEFAULT NULL,
  `fecha` date,
  `fecha_limite` date,
  `fecha_carga` date,
  `horas` time,
  `horas_maquina` time,
  `id_estado` int,
  `id_orden_mantenimiento` int,
  `id_responsabilidad` int,
  PRIMARY KEY (`id_parte_mantenimiento`),
  CONSTRAINT `pk_id_pm_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_pm_x_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_pm_x_orden_mantenimiento` FOREIGN KEY (`id_orden_mantenimiento`) REFERENCES `orden_mantenimiento`(`id_orden_mantenimiento`)
);

--------------------------------------------------
-- Insert iniciales
INSERT INTO sector (nombre_sector)
VALUES
    ('Comercial'),
    ('Calidad'),
    ('Mantenimiento');

INSERT INTO prioridad_solicitud (nombre_prioridad_solicitud)
VALUES
    ('Baja'),
    ('Programable'),
    ('Urgente');

INSERT INTO estado_solicitud (nombre_estado_solicitud)
VALUES
    ('En espera'),
    ('Aceptado'),
    ('Rechazado');

DROP TABLE parte_mantenimiento;
DROP TABLE orden_mantenimiento;
DROP TABLE parte_mecanizado;
DROP TABLE orden_mecanizado;
DROP TABLE orden_manufactura;
DROP TABLE parte_trabajo;
DROP TABLE orden_trabajo;
DROP TABLE etapa;
DROP TABLE tipo_etapa;
DROP TABLE maquinaria;
DROP TABLE actualizacion;
DROP TABLE servicio;
DROP TABLE responsabilidad;
DROP TABLE rol_empleado;
DROP TABLE empleado;
DROP TABLE puesto_empleado;
DROP TABLE estado;
DROP TABLE estado_mecanizado;
DROP TABLE prioridad;
DROP TABLE tipo_proyecto;
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