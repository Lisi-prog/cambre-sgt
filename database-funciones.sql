DELIMITER //

CREATE FUNCTION TotalOrdenTrabajoCompleto(servicio int)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE x INT;
    WITH 
	ParteRanked AS (
		SELECT
				p.id_orden,
                est.id_estado,
				ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
			FROM parte p
			inner join parte_trabajo pt on pt.id_parte = p.id_parte
			inner join estado est on est.id_estado = pt.id_estado
	)
	select count(o.id_orden) as total_completo into x from orden_trabajo o
	inner join ParteRanked pr on pr.id_orden = o.id_orden AND pr.rn = 1
	where o.id_orden in (select id_orden 
								from orden o
							where id_etapa in (select id_etapa from etapa where id_servicio in (servicio))) and pr.id_estado = 9; -- 9 completo en estado
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalOrdenMecCompleto(servicio int)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE x INT;
	WITH 
	ParteRanked AS (
		SELECT
				p.id_orden,
                est.id_estado_mecanizado,
				ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
			FROM parte p
			inner join parte_mecanizado pt on pt.id_parte = p.id_parte
			inner join estado_mecanizado est on est.id_estado_mecanizado = pt.id_estado_mecanizado
	)
	select count(o.id_orden) as total_completo into x from orden_mecanizado o
	inner join ParteRanked pr on pr.id_orden = o.id_orden AND pr.rn = 1
	where o.id_orden in (select id_orden 
							from orden o
						where id_etapa in (select id_etapa from etapa where id_servicio in (servicio))) and pr.id_estado_mecanizado=5; -- 5 completo en estado_mecanizado
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalOrdenManCompleto(servicio int)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE x INT;
	WITH
	ParteRanked AS (
		SELECT
				p.id_orden,
                est.id_estado_manufactura,
				ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
			FROM parte p
			inner join parte_manufactura pt on pt.id_parte = p.id_parte
			inner join estado_manufactura est on est.id_estado_manufactura = pt.id_estado_manufactura
	)
	select count(o.id_orden) as total_completo into x from orden_manufactura o
	inner join ParteRanked pr on pr.id_orden = o.id_orden AND pr.rn = 1
	where o.id_orden in (select id_orden 
							from orden o
							where id_etapa in (select id_etapa from etapa where id_servicio in (servicio))) and pr.id_estado_manufactura = 7; -- 7 completo en estado_manufactura
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalOrdenTrabajoCancelado(servicio int)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE x INT;
    WITH 
	ParteRanked AS (
		SELECT
				p.id_orden,
				est.id_estado,
				ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
			FROM parte p
			inner join parte_trabajo pt on pt.id_parte = p.id_parte
			inner join estado est on est.id_estado = pt.id_estado
	)
	select count(o.id_orden) as total_completo into x from orden_trabajo o
	inner join ParteRanked pr on pr.id_orden = o.id_orden AND pr.rn = 1
	where o.id_orden in (select id_orden 
								from orden o
							where id_etapa in (select id_etapa from etapa where id_servicio in (servicio))) and pr.id_estado = 10; -- 10 cancelado en estado
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalOrdenMecCancelado(servicio int)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE x INT;
	WITH 
	ParteRanked AS (
		SELECT
				p.id_orden,
                est.id_estado_mecanizado,
				ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
			FROM parte p
			inner join parte_mecanizado pt on pt.id_parte = p.id_parte
			inner join estado_mecanizado est on est.id_estado_mecanizado = pt.id_estado_mecanizado
	)
	select count(o.id_orden) as total_completo into x from orden_mecanizado o
	inner join ParteRanked pr on pr.id_orden = o.id_orden AND pr.rn = 1
	where o.id_orden in (select id_orden 
							from orden o
						where id_etapa in (select id_etapa from etapa where id_servicio in (servicio))) and pr.id_estado_mecanizado = 6; -- 6 cancelado en estado_mecanizado
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalOrdenManCancelado(servicio int)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE x INT;
	WITH
	ParteRanked AS (
		SELECT
				p.id_orden,
                est.id_estado_manufactura,
				ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
			FROM parte p
			inner join parte_manufactura pt on pt.id_parte = p.id_parte
			inner join estado_manufactura est on est.id_estado_manufactura = pt.id_estado_manufactura
	)
	select count(o.id_orden) as total_completo into x from orden_manufactura o
	inner join ParteRanked pr on pr.id_orden = o.id_orden AND pr.rn = 1
	where o.id_orden in (select id_orden 
							from orden o
							where id_etapa in (select id_etapa from etapa where id_servicio in (servicio))) and pr.id_estado_manufactura = 8; -- 8 cancelado de estado_manufactura
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER $$

CREATE FUNCTION TotalHorasRealOrden(orden INT)
RETURNS VARCHAR(10)
DETERMINISTIC
BEGIN
    DECLARE total_segundos INT;
    DECLARE resultado VARCHAR(10);
    
    -- Sumar los segundos totales
    SELECT 
        COALESCE(SUM(TIME_TO_SEC(p.horas)), 0)
    INTO total_segundos
    FROM 
        parte p
    WHERE 
        p.id_orden = orden;
    
    -- Calcular manualmente horas y minutos
    SET resultado = CONCAT(FLOOR(total_segundos / 3600), ':', LPAD(FLOOR((total_segundos % 3600) / 60), 2, '0'));
    
    RETURN resultado;
END$$

DELIMITER ;

DELIMITER $$

CREATE FUNCTION TotalHorasRealEtapa(etapa INT)
RETURNS VARCHAR(10)
DETERMINISTIC
BEGIN
    DECLARE total_segundos INT;
    DECLARE resultado VARCHAR(10);
    
    -- Sumar los segundos totales
    SELECT 
        COALESCE(SUM(TIME_TO_SEC(p.horas)), 0)
    INTO total_segundos
    FROM 
        parte p
    WHERE 
        p.id_orden in (select o.id_orden from orden o where o.id_etapa = etapa);
    
    -- Calcular manualmente horas y minutos
    SET resultado = CONCAT(FLOOR(total_segundos / 3600), ':', LPAD(FLOOR((total_segundos % 3600) / 60), 2, '0'));
    
    RETURN resultado;
END$$

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalHorasEstimadasEtapa(etapa INT)
RETURNS VARCHAR(10)
DETERMINISTIC
BEGIN
    DECLARE total_segundos INT;
    DECLARE resultado VARCHAR(10);
    
    -- Sumar los segundos totales
    SELECT 
        COALESCE(SUM(TIME_TO_SEC(o.duracion_estimada)), 0)
    INTO total_segundos
    FROM 
        orden o
    WHERE 
        o.id_etapa = etapa;
    
    -- Calcular manualmente horas y minutos
    SET resultado = CONCAT(FLOOR(total_segundos / 3600), ':', LPAD(FLOOR((total_segundos % 3600) / 60), 2, '0'));
    
    RETURN resultado;
END//

DELIMITER ;

DELIMITER //

CREATE FUNCTION `tiempoAMinutos`(`timeValue` TIME) 
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE hours INT;
    DECLARE minutes INT;
    DECLARE totalMinutes INT;

    SET hours = HOUR(timeValue);
    SET minutes = MINUTE(timeValue);
    SET totalMinutes = hours * 60 + minutes;

    RETURN totalMinutes;
END//

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalCostoEstimadoServicio(servicio int)
RETURNS float
DETERMINISTIC
BEGIN
    DECLARE x float;
	with
	Res_ord AS (
		select 
			res_ord.id_orden,
			res.id_rol_empleado,
			emp.nombre_empleado,
			emp.id_empleado,
			emp.costo_hora
		from responsabilidad_orden res_ord
		inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
		inner join empleado emp on res.id_empleado = emp.id_empleado
	)
	select
		sum(round(round(tiempoAMinutos(o.duracion_estimada) / 60, 2) * roo.costo_hora, 2)) as total_costo_hora into x
	from orden o 
	inner join Res_ord as roo on roo.id_orden = o.id_orden and roo.id_rol_empleado = 2
	where o.id_etapa in (select e.id_etapa from etapa e where e.id_servicio = servicio);
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalHorasEstimadoServicio(servicio int)
RETURNS VARCHAR(10)
DETERMINISTIC
BEGIN
    DECLARE total_segundos INT;
    DECLARE resultado VARCHAR(10);
    
    -- Sumar los segundos totales
    SELECT 
        COALESCE(SUM(TIME_TO_SEC(o.duracion_estimada)), 0)
    INTO total_segundos
    FROM 
        orden o
    WHERE 
        o.id_etapa in (select et.id_etapa from etapa et where et.id_servicio = servicio);
    
    -- Calcular manualmente horas y minutos
    SET resultado = CONCAT(FLOOR(total_segundos / 3600), ':', LPAD(FLOOR((total_segundos % 3600) / 60), 2, '0'));
    
    RETURN resultado;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalHorasRealServicio(servicio int)
RETURNS VARCHAR(10)
DETERMINISTIC
BEGIN
    DECLARE total_segundos INT;
    DECLARE resultado VARCHAR(10);
    
    SELECT 
        COALESCE(SUM(TIME_TO_SEC(p.horas)), 0)
    INTO total_segundos
    FROM 
        parte p
    WHERE 
        p.id_orden in (select o.id_orden from orden o where o.id_etapa in (select et.id_etapa from etapa et where et.id_servicio = servicio ));
    
    -- Calcular manualmente horas y minutos
    SET resultado = CONCAT(FLOOR(total_segundos / 3600), ':', LPAD(FLOOR((total_segundos % 3600) / 60), 2, '0'));
    
    RETURN resultado;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalCostoRealServicio(servicio int)
RETURNS float
DETERMINISTIC
BEGIN
    DECLARE x float;
	select 
	sum(
        case
			when round(round(tiempoAMinutos(p.horas) / 60, 2) * p.costo, 2) is null then 0
            else round(round(tiempoAMinutos(p.horas) / 60, 2) * p.costo, 2)
        end
        ) as costo_total_parte into x
        from parte p 
        where p.id_orden in (select o.id_orden from orden o where o.id_etapa in (select et.id_etapa from etapa et where et.id_servicio = servicio));
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalCostoRealEtapa(etapa int)
RETURNS float
DETERMINISTIC
BEGIN
    DECLARE x float;
	select 
	sum(
        case
			when round(round(tiempoAMinutos(p.horas) / 60, 2) * p.costo, 2) is null then 0
            else round(round(tiempoAMinutos(p.horas) / 60, 2) * p.costo, 2)
        end
        ) as costo_total_parte into x
        from parte p 
        where p.id_orden in (select o.id_orden from orden o where o.id_etapa = etapa);
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalCostoEstimadoEtapa(etapa int)
RETURNS float
DETERMINISTIC
BEGIN
    DECLARE x float;
	with
	Res_ord AS (
		select 
			res_ord.id_orden,
			res.id_rol_empleado,
			emp.nombre_empleado,
			emp.id_empleado,
			emp.costo_hora
		from responsabilidad_orden res_ord
		inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
		inner join empleado emp on res.id_empleado = emp.id_empleado
	)
	select
		sum(round(round(tiempoAMinutos(o.duracion_estimada) / 60, 2) * roo.costo_hora, 2)) as total_costo_hora into x
	from orden o 
	inner join Res_ord as roo on roo.id_orden = o.id_orden and roo.id_rol_empleado = 2
	where o.id_etapa = etapa;
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION ObtenerFechaFinalizacionEtapa(etapa int)
	RETURNS varchar(20)
	DETERMINISTIC
	BEGIN
		DECLARE fecha varchar(20);
		DECLARE estado_etapa int;
            
		select est.id_estado into estado_etapa from etapa et 
			inner join actualizacion_etapa act_et on act_et.id_etapa = et.id_etapa
            inner join actualizacion act on act.id_actualizacion = act_et.id_actualizacion
            inner join estado est on est.id_estado = act.id_estado
				where et.id_etapa = etapa
            order by act_et.id_actualizacion_etapa desc limit 1;
        
        IF estado_etapa = 9 THEN
            select Date(act.fecha_carga) into fecha
				from actualizacion_etapa act_et 
				inner join actualizacion act on act.id_actualizacion = act_et.id_actualizacion
				where act_et.id_etapa = etapa and act.id_estado = 9
				order by act_et.id_actualizacion_etapa limit 1;
        ELSE
            SET fecha = '____-__-__';
        END IF;
        
        IF fecha is null THEN
			set fecha = '____-__-__';
        END IF;
        
		RETURN fecha;
	END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalCostoEstimadoOrden(orden int)
RETURNS float
DETERMINISTIC
BEGIN
    DECLARE x float;
	with
	Res_ord AS (
		select 
			res_ord.id_orden,
			res.id_rol_empleado,
			emp.nombre_empleado,
			emp.id_empleado,
			emp.costo_hora
		from responsabilidad_orden res_ord
		inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
		inner join empleado emp on res.id_empleado = emp.id_empleado
	)
	select
		sum(round(round(tiempoAMinutos(o.duracion_estimada) / 60, 2) * roo.costo_hora, 2)) as total_costo_hora into x
        -- sum(round(round(tiempoAMinutos(o.duracion_estimada), 2) * (roo.costo_hora/60), 2)) as total_costo_hora into x
	from orden o 
	inner join Res_ord as roo on roo.id_orden = o.id_orden and roo.id_rol_empleado = 2
	where o.id_orden = orden;
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION TotalCostoRealOrden(orden int)
RETURNS float
DETERMINISTIC
BEGIN
    DECLARE x float;
	select 
	sum(
        case
			when round(round(tiempoAMinutos(p.horas) / 60, 2) * p.costo, 2) is null then 0
            else round(round(tiempoAMinutos(p.horas) / 60, 2) * p.costo, 2)
        end
        ) as costo_total_parte into x
        from parte p 
        where p.id_orden = orden;
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION ObtenerTotalOrdenMecxMan(orden int)
RETURNS int
DETERMINISTIC
BEGIN
    DECLARE x int;
	select 
		count(ome.id_orden_mecanizado) as costo_total_parte into x
        from orden_mecanizado ome 
        where ome.id_orden_manufactura = orden;
                        
    RETURN x;
END //

DELIMITER ;

DELIMITER //

CREATE FUNCTION ObtenerTotalOrdenMecxManCompleto(orden int)
RETURNS int
DETERMINISTIC
BEGIN
    DECLARE x int;
	WITH 
	ParteRanked AS (
		SELECT
			p.id_parte,
			pt.id_estado_mecanizado,
			p.fecha_limite,
			p.id_orden,
			est.nombre_estado_mecanizado,
			ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
		FROM parte p
		inner join parte_mecanizado pt on pt.id_parte = p.id_parte
		inner join estado_mecanizado est on est.id_estado_mecanizado = pt.id_estado_mecanizado
	)
		select 
			count(omec.id_orden_mecanizado) as total_mecanizado into x
		from orden_mecanizado omec 
		INNER JOIN ParteRanked AS p_rank ON p_rank.id_orden = omec.id_orden AND p_rank.rn = 1
		where omec.id_orden_manufactura = orden and p_rank.id_estado_mecanizado = 6;
                        
    RETURN x;
END //

DELIMITER ;