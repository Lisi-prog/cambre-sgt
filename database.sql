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
  PRIMARY KEY (`id_propuesta_de_mejora`),
  CONSTRAINT `pk_id_prop_de_mejora_x_solicitud` FOREIGN KEY (`id_solicitud`) REFERENCES `sol_solicitud`(`id_solicitud`)
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
  `id_activo` int,
  PRIMARY KEY (`id_servicio`),
  CONSTRAINT `pk_id_servicio_x_responsabilidad` FOREIGN KEY (`id_responsabilidad`) REFERENCES `responsabilidad`(`id_responsabilidad`),
  CONSTRAINT `pk_id_servicio_x_subtipo_servicio` FOREIGN KEY (`id_subtipo_servicio`) REFERENCES `subtipo_servicio`(`id_subtipo_servicio`)
);
-- -----------------------//

CREATE TABLE `maquinaria` (
  `id_maquinaria` int NOT NULL AUTO_INCREMENT,
  `codigo_maquinaria` varchar(50) DEFAULT NULL,
  `alias_maquinaria` varchar(50) DEFAULT NULL,
  `descripcion_maquinaria` varchar(300),
  `id_sector` int,
  PRIMARY KEY (`id_maquinaria`)
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

CREATE VIEW vw_servicio AS
select se.id_servicio, se.prioridad_servicio, se.codigo_servicio, se.nombre_servicio, stb.id_subtipo_servicio, stb.nombre_subtipo_servicio, tb.id_tipo_servicio, tb.nombre_tipo_servicio, se.fecha_inicio, emp.id_empleado, emp.nombre_empleado as lider, act_se.id_actualizacion, act.fecha_limite, est.id_estado, est.nombre_estado    
inner join responsabilidad as res on se.id_responsabilidad = res.id_responsabilidad
    inner join empleado as emp on res.id_empleado = emp.id_empleado
    inner join (select act_s.id_actualizacion_servicio, max(act_s.id_actualizacion) as id_actualizacion, act_s.id_servicio 
			          from actualizacion_servicio as act_s 
                group by act_s.id_servicio) as act_se on act_se.id_servicio = se.id_servicio
    inner join actualizacion as act on act.id_actualizacion=act_se.id_actualizacion
    inner join estado as est on act.id_estado=est.id_estado;


CREATE VIEW vw_servicio AS
WITH ActualizacionRanked AS (
    SELECT
        act_s.id_servicio,
        act_s.id_actualizacion_servicio,
        act_s.id_actualizacion,
        ROW_NUMBER() OVER (PARTITION BY act_s.id_servicio ORDER BY act_s.id_actualizacion DESC) AS rn
    FROM actualizacion_servicio AS act_s
)
SELECT
    se.id_servicio,
    se.prioridad_servicio,
    se.codigo_servicio,
    se.nombre_servicio,
    se.id_activo,
    stb.id_subtipo_servicio,
    stb.nombre_subtipo_servicio,
    tb.id_tipo_servicio,
    tb.nombre_tipo_servicio,
    se.fecha_inicio,
    emp.id_empleado,
    emp.nombre_empleado AS lider,
    act_se.id_actualizacion,
    act.fecha_limite,
    est.id_estado,
    est.nombre_estado
FROM servicio AS se
INNER JOIN subtipo_servicio AS stb ON stb.id_subtipo_servicio = se.id_subtipo_servicio
INNER JOIN tipo_servicio AS tb ON stb.id_tipo_servicio = tb.id_tipo_servicio
INNER JOIN responsabilidad AS res ON se.id_responsabilidad = res.id_responsabilidad
INNER JOIN empleado AS emp ON res.id_empleado = emp.id_empleado
INNER JOIN ActualizacionRanked AS act_se ON act_se.id_servicio = se.id_servicio AND act_se.rn = 1
INNER JOIN actualizacion AS act ON act.id_actualizacion = act_se.id_actualizacion
INNER JOIN estado AS est ON act.id_estado = est.id_estado;


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