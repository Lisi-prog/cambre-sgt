CREATE TABLE `tipo_sintoma` (
	`id_tipo_sintoma` INT(11) NOT NULL AUTO_INCREMENT,
	`nombre_tipo_sintoma` VARCHAR(150) NOT NULL DEFAULT '' COLLATE 'utf8mb4_uca1400_ai_ci',
	PRIMARY KEY (`id_tipo_sintoma`) USING BTREE
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

CREATE TABLE `sintoma` (
	`id_sintoma` INT(11) NOT NULL AUTO_INCREMENT,
	`nombre_sintoma` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`id_tipo_sintoma` INT(11) NOT NULL,
	PRIMARY KEY (`id_sintoma`) USING BTREE,
	INDEX `FK_tipo_sintoma` (`id_tipo_sintoma`) USING BTREE,
	CONSTRAINT `FK_tipo_sintoma` FOREIGN KEY (`id_tipo_sintoma`) REFERENCES `tipo_sintoma` (`id_tipo_sintoma`) ON UPDATE NO ACTION ON DELETE RESTRICT
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;
CREATE TABLE `tipo_activo_x_sintoma` (
	`id_tipo_activo_x_sintoma` INT(11) NOT NULL AUTO_INCREMENT,
	`id_tipo_activo` INT(11) NOT NULL,
	`id_sintoma` INT(11) NOT NULL,
	PRIMARY KEY (`id_tipo_activo_x_sintoma`) USING BTREE,
	UNIQUE INDEX `id_tipo_activo_id_sintoma` (`id_tipo_activo`, `id_sintoma`) USING BTREE,
	INDEX `FK_sintoma` (`id_sintoma`) USING BTREE,
	CONSTRAINT `FK_sintoma` FOREIGN KEY (`id_sintoma`) REFERENCES `sintoma` (`id_sintoma`) ON UPDATE NO ACTION ON DELETE RESTRICT,
	CONSTRAINT `FK_tipo_activo` FOREIGN KEY (`id_tipo_activo`) REFERENCES `tipo_activo` (`id_tipo_activo`) ON UPDATE NO ACTION ON DELETE RESTRICT
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `sol_serv_man_x_sintoma` (
	`id_sol_serv_man_x_sintoma` INT(11) NOT NULL AUTO_INCREMENT,
	`id_servicio_de_mantenimiento` INT(11) NOT NULL,
	`id_sintoma` INT(11) NOT NULL,
	PRIMARY KEY (`id_sol_serv_man_x_sintoma`) USING BTREE,
	UNIQUE INDEX `id_servicio_de_mantenimiento_id_sintoma` (`id_servicio_de_mantenimiento`, `id_sintoma`) USING BTREE,
	INDEX `FK_sintoma` (`id_sintoma`) USING BTREE,
	CONSTRAINT `FK_sintoma` FOREIGN KEY (`id_sintoma`) REFERENCES `sintoma` (`id_sintoma`) ON UPDATE NO ACTION ON DELETE RESTRICT,
	CONSTRAINT `FK_sol_serv_man_x_sintoma_sol_servicio_de_mantenimiento` FOREIGN KEY (`id_servicio_de_mantenimiento`) REFERENCES `sol_servicio_de_mantenimiento` (`id_servicio_de_mantenimiento`) ON UPDATE NO ACTION ON DELETE RESTRICT
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
CREATE TABLE `activo_x_sintoma` (
	`id_activo_x_sintoma` INT(11) NOT NULL AUTO_INCREMENT,
	`id_activo` INT(11) NOT NULL,
	`id_sintoma` INT(11) NOT NULL,
	PRIMARY KEY (`id_activo_x_sintoma`) USING BTREE,
	UNIQUE INDEX `id_activo_id_sintoma` (`id_activo`, `id_sintoma`) USING BTREE,
	INDEX `FK_sintoma` (`id_sintoma`) USING BTREE,
	CONSTRAINT `FK_activo` FOREIGN KEY (`id_activo`) REFERENCES `activo` (`id_activo`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `FK_sintoma` FOREIGN KEY (`id_sintoma`) REFERENCES `sintoma` (`id_sintoma`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;
CREATE TABLE `parte_diagnostico` (
	`id_parte_diagnostico` INT(11) NOT NULL AUTO_INCREMENT,
	`id_parte` INT(11) NOT NULL,
	`id_estado` INT(11) NOT NULL,
	`en_maquina` TINYINT(1) NOT NULL DEFAULT '0',
	`en_banco` TINYINT(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id_parte_diagnostico`) USING BTREE,
	INDEX `FK_parte` (`id_parte`) USING BTREE,
	CONSTRAINT `FK_parte` FOREIGN KEY (`id_parte`) REFERENCES `parte` (`id_parte`) ON UPDATE NO ACTION ON DELETE RESTRICT
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
CREATE TABLE `ishikawa_categoria` (
	`id_ishikawa_categoria` INT(11) NOT NULL AUTO_INCREMENT,
	`codigo_categoria` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`nombre_categoria` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	PRIMARY KEY (`id_ishikawa_categoria`) USING BTREE,
	UNIQUE INDEX `codigo_categoria` (`codigo_categoria`) USING BTREE
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `ishikawa_causa` (
	`id_ishikawa_causa` INT(11) NOT NULL AUTO_INCREMENT,
	`id_ishikawa_categoria` INT(11) NOT NULL,
	`nombre_causa` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`explicacion` VARCHAR(200) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	PRIMARY KEY (`id_ishikawa_causa`) USING BTREE,
	INDEX `FK_ishikawa_categoria` (`id_ishikawa_categoria`) USING BTREE,
	CONSTRAINT `FK_ishikawa_categoria` FOREIGN KEY (`id_ishikawa_categoria`) REFERENCES `ishikawa_categoria` (`id_ishikawa_categoria`) ON UPDATE NO ACTION ON DELETE RESTRICT
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
CREATE TABLE `parte_diag_x_causa` (
	`id_parte_diag_x_causa` INT(11) NOT NULL AUTO_INCREMENT,
	`id_parte_diagnostico` INT(11) NOT NULL,
	`id_ishikawa_causa` INT(11) NOT NULL,
	PRIMARY KEY (`id_parte_diag_x_causa`) USING BTREE,
	UNIQUE INDEX `id_parte_diagnostico_id_ishikawa_causa` (`id_parte_diagnostico`, `id_ishikawa_causa`) USING BTREE,
	INDEX `FK_ishikawa_causa` (`id_ishikawa_causa`) USING BTREE,
	CONSTRAINT `FK_ishikawa_causa` FOREIGN KEY (`id_ishikawa_causa`) REFERENCES `ishikawa_causa` (`id_ishikawa_causa`) ON UPDATE NO ACTION ON DELETE RESTRICT,
	CONSTRAINT `FK_parte_diagnostico` FOREIGN KEY (`id_parte_diagnostico`) REFERENCES `parte_diagnostico` (`id_parte_diagnostico`) ON UPDATE NO ACTION ON DELETE RESTRICT
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
CREATE TABLE `tarea_ejecucion` (
	`id_ejecucion` INT(11) NOT NULL AUTO_INCREMENT,
	`nombre_ejecucion` VARCHAR(200) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	PRIMARY KEY (`id_ejecucion`) USING BTREE
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
CREATE TABLE `zona_tarea` (
	`id_zona_tarea` INT(11) NOT NULL AUTO_INCREMENT,
	`nombre_zona` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	PRIMARY KEY (`id_zona_tarea`) USING BTREE
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
CREATE TABLE `tarea_mantenimiento` (
	`id_tarea_mantenimiento` INT(11) NOT NULL AUTO_INCREMENT,
	`nombre_tarea` VARCHAR(200) NOT NULL COLLATE 'utf8mb4_uca1400_ai_ci',
	`id_ejecucion` INT(11) NOT NULL,
	`id_zona_tarea` INT(11) NOT NULL,
	PRIMARY KEY (`id_tarea_mantenimiento`) USING BTREE,
	INDEX `FK_ejecucion` (`id_ejecucion`) USING BTREE,
	INDEX `FK_zona_tarea` (`id_zona_tarea`) USING BTREE,
	CONSTRAINT `FK_ejecucion` FOREIGN KEY (`id_ejecucion`) REFERENCES `tarea_ejecucion` (`id_ejecucion`) ON UPDATE NO ACTION ON DELETE RESTRICT,
	CONSTRAINT `FK_zona_tarea` FOREIGN KEY (`id_zona_tarea`) REFERENCES `zona_tarea` (`id_zona_tarea`) ON UPDATE NO ACTION ON DELETE RESTRICT
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
CREATE TABLE `activo_x_tarea_mant` (
	`id_activo_x_tarea_mant` INT(11) NOT NULL AUTO_INCREMENT,
	`id_activo` INT(11) NOT NULL,
	`id_tarea_mantenimiento` INT(11) NOT NULL,
	PRIMARY KEY (`id_activo_x_tarea_mant`) USING BTREE,
	UNIQUE INDEX `id_activo_id_tarea_mantenimiento` (`id_activo`, `id_tarea_mantenimiento`) USING BTREE,
	INDEX `FK_tarea_mantenimiento` (`id_tarea_mantenimiento`) USING BTREE,
	CONSTRAINT `FK_activo` FOREIGN KEY (`id_activo`) REFERENCES `activo` (`id_activo`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `FK_tarea_mantenimiento` FOREIGN KEY (`id_tarea_mantenimiento`) REFERENCES `tarea_mantenimiento` (`id_tarea_mantenimiento`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
CREATE TABLE `tipo_activo_x_tarea_mant` (
	`id_tipo_activo_x_tarea_mant` INT(11) NOT NULL AUTO_INCREMENT,
	`id_tipo_activo` INT(11) NOT NULL,
	`id_tarea_mantenimiento` INT(11) NOT NULL,
	PRIMARY KEY (`id_tipo_activo_x_tarea_mant`) USING BTREE,
	UNIQUE INDEX `id_tipo_activo_id_tarea_mantenimiento` (`id_tipo_activo`, `id_tarea_mantenimiento`) USING BTREE,
	INDEX `FK_tarea_mantenimiento` (`id_tarea_mantenimiento`) USING BTREE,
	CONSTRAINT `FK_tarea_mantenimiento` FOREIGN KEY (`id_tarea_mantenimiento`) REFERENCES `tarea_mantenimiento` (`id_tarea_mantenimiento`) ON UPDATE NO ACTION ON DELETE RESTRICT,
	CONSTRAINT `FK_tipo_activo` FOREIGN KEY (`id_tipo_activo`) REFERENCES `tipo_activo` (`id_tipo_activo`) ON UPDATE NO ACTION ON DELETE RESTRICT
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
