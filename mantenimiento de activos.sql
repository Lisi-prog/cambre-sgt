CREATE TABLE `tipo_sintoma` (
	`id_tipo_sintoma` INT(11) NOT NULL AUTO_INCREMENT,
	`nombre_tipo_sintoma` VARCHAR(150) NOT NULL DEFAULT '' COLLATE 'utf8mb4_uca1400_ai_ci',
	PRIMARY KEY (`id_tipo_sintoma`) USING BTREE
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
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
;
CREATE TABLE `tipo_activo_x_sintoma` (
	`id_tipo_activo` INT(11) NOT NULL,
	`id_sintoma` INT(11) NOT NULL,
	PRIMARY KEY (`id_tipo_activo`, `id_sintoma`) USING BTREE,
	INDEX `FK_sintoma` (`id_sintoma`) USING BTREE,
	CONSTRAINT `FK_sintoma` FOREIGN KEY (`id_sintoma`) REFERENCES `sintoma` (`id_sintoma`) ON UPDATE NO ACTION ON DELETE RESTRICT,
	CONSTRAINT `FK_tipo_activo` FOREIGN KEY (`id_tipo_activo`) REFERENCES `tipo_activo` (`id_tipo_activo`) ON UPDATE NO ACTION ON DELETE RESTRICT
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
CREATE TABLE `sol_serv_man_x_sintoma` (
	`id_servicio_de_mantenimiento` INT(11) NOT NULL,
	`id_sintoma` INT(11) NOT NULL,
	PRIMARY KEY (`id_servicio_de_mantenimiento`, `id_sintoma`) USING BTREE,
	INDEX `FK_sintoma` (`id_sintoma`) USING BTREE,
	CONSTRAINT `FK_servicio_de_mantenimiento` FOREIGN KEY (`id_servicio_de_mantenimiento`) REFERENCES `sol_servicio_de_mantenimiento` (`id_servicio_de_mantenimiento`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `FK_sintoma` FOREIGN KEY (`id_sintoma`) REFERENCES `sintoma` (`id_sintoma`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
COLLATE='utf8mb4_uca1400_ai_ci'
ENGINE=InnoDB
;
