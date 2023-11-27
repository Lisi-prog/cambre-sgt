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

CREATE TABLE `empleado` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `nombre_empleado` varchar(150) NOT NULL,
  `email_empleado` varchar(50),
  `telefono_empleado` varchar(50),
  `user_id` bigInt,
  PRIMARY KEY (`id_empleado`)
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

CREATE TABLE `proyecto` (
  `id_proyecto` int NOT NULL AUTO_INCREMENT,
  `codigo_proyecto` varchar(50) DEFAULT NULL,
  `nombre_proyecto` varchar(50) DEFAULT NULL,
  `fecha_inicio` date,
  `fecha_limite` date,
  `id_empleado` int,
  `id_rol_empleado` int,
  PRIMARY KEY (`id_proyecto`),
  CONSTRAINT `pk_py_id_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleado`(`id_empleado`),
  CONSTRAINT `pk_py_id_rol_empleado` FOREIGN KEY (`id_rol_empleado`) REFERENCES `rol_empleado`(`id_rol_empleado`)
);

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
  `id_proyecto` int,
  `id_responsabilidad` int,
  `id_estado` int,
  `id_tipo_etapa` int,
  `id_actualizacion` int,
  PRIMARY KEY (`id_etapa`),
  CONSTRAINT `pk_id_etapaxpy_proyecto` FOREIGN KEY (`id_proyecto`) REFERENCES `proyecto`(`id_proyecto`),
  CONSTRAINT `pk_id_etapaxres_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_etapaxest_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_etapaxte_tipo_etapa` FOREIGN KEY (`id_tipo_etapa`) REFERENCES `tipo_etapa`(`id_tipo_etapa`),
  CONSTRAINT `pk_id_etapaxact_actualizacion` FOREIGN KEY (`id_actualizacion`) REFERENCES `actualizacion`(`id_actualizacion`)
);

CREATE TABLE `orden_trabajo` (
  `id_orden_trabajo` int NOT NULL AUTO_INCREMENT,
  `nombre_orden_trabajo` varchar(50) DEFAULT NULL,
  `descripcion_etapa` varchar(50) DEFAULT NULL,
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
  CONSTRAINT `pk_id_etapa` FOREIGN KEY (`id_etapa`) REFERENCES `etapa`(`id_etapa`),
);

CREATE TABLE `parte_mantenimiento` (
  `id_parte_mecanizado` int NOT NULL AUTO_INCREMENT,
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
  CONSTRAINT `pk_id_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado`(`id_estado`),
  CONSTRAINT `pk_id_orden_mantenimiento` FOREIGN KEY (`id_orden_mantenimiento`) REFERENCES `orden_mantenimiento`(`id_orden_mantenimiento`)
);