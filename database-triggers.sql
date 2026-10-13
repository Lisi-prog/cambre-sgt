DELIMITER $$

CREATE TRIGGER `TRG_tpxa_historial_before_update`
BEFORE UPDATE ON `tarea_prev_x_activo`
FOR EACH ROW
BEGIN
    INSERT INTO `tarea_prev_x_activo_historial` (
        `id_tarea_prev_x_activo`,
        `id_activo`,
        `id_tarea_mantenimiento`,
        `intervalo_dias`,
        `cant_golpes`,
        `fecha_ultima_ejecucion`,
        `fecha_carga`
    )
    VALUES (
        OLD.id_tarea_prev_x_activo,
        OLD.id_activo,
        OLD.id_tarea_mantenimiento,
        OLD.intervalo_dias,
        OLD.cant_golpes,
        OLD.fecha_ultima_ejecucion,
        CURRENT_TIMESTAMP
    );
END$$

DELIMITER ;