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
  `id_servicio` int,
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

-- CREATE TABLE `prioridad` (
--  `id_prioridad` int NOT NULL AUTO_INCREMENT,
--  `nombre_prioridad` varchar(50) DEFAULT NULL,
--  PRIMARY KEY (`id_prioridad`)
-- );

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

CREATE TABLE `estado_manufactura` (
  `id_estado_manufactura` int NOT NULL AUTO_INCREMENT,
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
  `id_responsabilidad` int,
  `id_subtipo_servicio` int,
  `prioridad_servicio` int,
  PRIMARY KEY (`id_servicio`),
  CONSTRAINT `pk_id_servicio_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_servicio_x_subtipo_servicio` FOREIGN KEY (`id_subtipo_servicio`) REFERENCES `subtipo_servicio`(`id_subtipo_servicio`)
);
-- -----------------------//

CREATE TABLE `maquinaria` (
  `id_maquinaria` int NOT NULL AUTO_INCREMENT,
  `codigo_maquinaria` varchar(50) DEFAULT NULL,
  `alias_maquinaria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_maquinaria`)
);

CREATE TABLE `etapa` (
  `id_etapa` int NOT NULL AUTO_INCREMENT,
  `nombre_etapa` varchar(50) DEFAULT NULL,
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

CREATE TABLE `orden`(
  `id_orden` int NOT NULL AUTO_INCREMENT,
  `nombre_orden` varchar(50),
  `fecha_inicio` date,
  `duracion_estimada` time,
  `id_etapa` int,
  PRIMARY KEY(`id_orden`),
  CONSTRAINT `pk_id_orden_x_etapa` FOREIGN KEY (`id_etapa`) REFERENCES `etapa`(`id_etapa`)
);

CREATE TABLE `responsabilidad_orden`(
  `id_responsabilidad_orden` int,
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
  `fecha_limite` date NOT NULL,
  `fecha_carga` datetime NOT NULL,
  `horas` time NOT NULL,
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

CREATE TABLE `parte_mecanizado` (
  `id_parte_mecanizado` int NOT NULL AUTO_INCREMENT,
  `id_estado_mecanizado` int,
  `id_parte` int,
  PRIMARY KEY (`id_parte_mecanizado`),
  CONSTRAINT `pk_id_parte_mecanizado_x_estado_mecanizado` FOREIGN KEY (`id_estado_mecanizado`) REFERENCES `estado_mecanizado`(`id_estado_mecanizado`),
  CONSTRAINT `pk_id_parte_mecanizado_x_parte` FOREIGN KEY (`id_parte`) REFERENCES `parte`(`id_parte`)
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

CREATE TABLE `parte_mecanizado_x_maquinaria` (
  `id_parte_mec_x_maq` int NOT NULL AUTO_INCREMENT,
  `id_parte_mecanizado` int,
  `id_maquinaria` boolean,
  `horas_maquina` time,
  PRIMARY KEY (`id_parte_mec_x_maq`),
  CONSTRAINT `pk_id_parte_mec_x_maq_x_parte_mec` FOREIGN KEY (`id_parte_mecanizado`) REFERENCES `parte_mecanizado`(`id_parte_mecanizado`),
  CONSTRAINT `pk_id_parte_mec_x_maq_x_maq` FOREIGN KEY (`id_maquinaria`) REFERENCES `maquinaria`(`id_maquinaria`)
);

CREATE TABLE `parte_mantenimiento_x_maquinaria` (
  `id_parte_man_x_maq` int NOT NULL AUTO_INCREMENT,
  `id_parte_mantenimiento` int,
  `id_maquinaria` boolean,
  `horas_maquina` time,
  PRIMARY KEY (`id_parte_man_x_maq`),
  CONSTRAINT `pk_id_parte_man_x_maq_x_parte_man` FOREIGN KEY (`id_parte_mantenimiento`) REFERENCES `parte_mantenimiento`(`id_parte_mantenimiento`),
  CONSTRAINT `pk_id_parte_man_x_maq_x_maq` FOREIGN KEY (`id_maquinaria`) REFERENCES `maquinaria`(`id_maquinaria`)
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
    ('Tarea', 1);

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

INSERT INTO estado(nombre_estado)
VALUES
  ('Cancelado'),
  ('Completo'),
  ('Continua'),
  ('En proceso'),
  ('Externo'),
  ('Espera'),
  ('Revisar'),
  ('Pausa'),
  ('Problema');

INSERT INTO estado_mecanizado(nombre_estado_mecanizado)
VALUES
  ('Cancelado'),
  ('Material encargado'),
  ('Material preparado'),
  ('Mecanizado completo'),
  ('Pieza finalizada'),
  ('Planos entregados'),
  ('Temple');



DROP TABLE parte_mantenimiento;
DROP TABLE orden_mantenimiento;
DROP TABLE parte_mecanizado;
DROP TABLE orden_mecanizado;
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