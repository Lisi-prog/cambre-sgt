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
    est.nombre_estado,
    case
      when si.tot_ord is null then 0
      else si.tot_ord
    end as total_ord,
    
    case
		  when si.tot_ord_completa is null then 0
      else si.tot_ord_completa
	  end as total_ord_completa,
    
    case
		  when si.progreso is null then 0
      else si.progreso
	  end as progreso
FROM servicio AS se
INNER JOIN subtipo_servicio AS stb ON stb.id_subtipo_servicio = se.id_subtipo_servicio
INNER JOIN tipo_servicio AS tb ON stb.id_tipo_servicio = tb.id_tipo_servicio
INNER JOIN responsabilidad AS res ON se.id_responsabilidad = res.id_responsabilidad
INNER JOIN empleado AS emp ON res.id_empleado = emp.id_empleado
INNER JOIN ActualizacionRanked AS act_se ON act_se.id_servicio = se.id_servicio AND act_se.rn = 1
INNER JOIN actualizacion AS act ON act.id_actualizacion = act_se.id_actualizacion
INNER JOIN estado AS est ON act.id_estado = est.id_estado
LEFT JOIN servicio_info si ON si.id_servicio = se.id_servicio;

CREATE VIEW vw_orden_trabajo AS
WITH 
ParteRanked AS (
    SELECT
        p.id_parte,
        pt.id_estado,
        p.fecha_limite,
        p.id_orden,
        est.nombre_estado,
        CASE
			WHEN est.id_estado = 9 THEN p.fecha
            ELSE "____-__-__"
		END as fecha_finalizacion,
        ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
    FROM parte p
    inner join parte_trabajo pt on pt.id_parte = p.id_parte
    inner join estado est on est.id_estado = pt.id_estado
),
Res_ord AS (
	select 
		res_ord.id_orden,
		res.id_rol_empleado,
		emp.nombre_empleado,
        emp.id_empleado
	from responsabilidad_orden res_ord
	inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
	inner join empleado emp on res.id_empleado = emp.id_empleado
)

select 
	se.prioridad_servicio,
    se.id_servicio,
	se.codigo_servicio,
    se.nombre_servicio,
    o.id_orden,
	  o.nombre_orden,
    et.id_etapa,
    et.descripcion_etapa,
    p_rank.fecha_limite,
    p_rank.fecha_finalizacion,
    roo.nombre_empleado as responsable,
    roo.id_empleado as id_empleado_responsable,
    ro.nombre_empleado as supervisor,
    ro.id_empleado as id_empleado_supervisor,
    p_rank.nombre_estado,
	th.total_horas
    from orden as o
	inner join orden_trabajo as ot on o.id_orden = ot.id_orden
	inner join etapa as et on et.id_etapa = o.id_etapa
	inner join servicio as se on se.id_servicio = et.id_servicio
  INNER JOIN ParteRanked AS p_rank ON p_rank.id_orden = o.id_orden AND p_rank.rn = 1
  inner join Res_ord as ro on ro.id_orden = o.id_orden and ro.id_rol_empleado = 3
  inner join Res_ord as roo on roo.id_orden = o.id_orden and roo.id_rol_empleado = 2
  inner join (SELECT  p.id_orden, SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) ) AS total_horas FROM parte p group by p.id_orden) as th on th.id_orden = o.id_orden
  order by se.prioridad_servicio;


CREATE VIEW vw_orden_manufactura AS
WITH 
ParteRanked AS (
    SELECT
        p.id_parte,
        pt.id_estado_manufactura,
        p.fecha_limite,
        p.id_orden,
        est.nombre_estado_manufactura,
        CASE
			WHEN est.id_estado_manufactura = 7 THEN p.fecha -- completo en estado_manufactura
            ELSE "____-__-__"
		END as fecha_finalizacion,
        ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
    FROM parte p
    inner join parte_manufactura pt on pt.id_parte = p.id_parte
    inner join estado_manufactura est on est.id_estado_manufactura = pt.id_estado_manufactura
),
Res_ord AS (
	select 
		res_ord.id_orden,
		res.id_rol_empleado,
		emp.nombre_empleado,
        emp.id_empleado
	from responsabilidad_orden res_ord
	inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
	inner join empleado emp on res.id_empleado = emp.id_empleado
)

select 
	se.prioridad_servicio,
    se.id_servicio,
	se.codigo_servicio,
    se.nombre_servicio,
    o.id_orden,
	o.nombre_orden,
    et.descripcion_etapa,
    p_rank.fecha_limite,
    p_rank.fecha_finalizacion,
    roo.nombre_empleado as responsable,
    roo.id_empleado as id_empleado_responsable,
    ro.nombre_empleado as supervisor,
    ro.id_empleado as id_empleado_supervisor,
    p_rank.nombre_estado_manufactura as nombre_estado,
    th.total_horas
    from orden as o
	inner join orden_manufactura as ot on o.id_orden = ot.id_orden
	inner join etapa as et on et.id_etapa = o.id_etapa
	inner join servicio as se on se.id_servicio = et.id_servicio
  INNER JOIN ParteRanked AS p_rank ON p_rank.id_orden = o.id_orden AND p_rank.rn = 1
  inner join Res_ord as ro on ro.id_orden = o.id_orden and ro.id_rol_empleado = 3
  inner join Res_ord as roo on roo.id_orden = o.id_orden and roo.id_rol_empleado = 2
  inner join (SELECT  p.id_orden, SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) ) AS total_horas FROM parte p group by p.id_orden) as th on th.id_orden = o.id_orden
    order by se.prioridad_servicio;


CREATE VIEW vw_orden_mecanizado AS
WITH 
ParteRanked AS (
    SELECT
        p.id_parte,
        pt.id_estado_mecanizado,
        p.fecha_limite,
        p.id_orden,
        est.nombre_estado_mecanizado,
        CASE
			WHEN est.id_estado_mecanizado = 5 THEN p.fecha -- completo en estado_mecanizado
            ELSE "____-__-__"
		END as fecha_finalizacion,
        ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
    FROM parte p
    inner join parte_mecanizado pt on pt.id_parte = p.id_parte
    inner join estado_mecanizado est on est.id_estado_mecanizado = pt.id_estado_mecanizado
),
Res_ord AS (
	select 
		res_ord.id_orden,
		res.id_rol_empleado,
		emp.nombre_empleado,
        emp.id_empleado
	from responsabilidad_orden res_ord
	inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
	inner join empleado emp on res.id_empleado = emp.id_empleado
)

select 
	se.prioridad_servicio,
    se.id_servicio,
	se.codigo_servicio,
    se.nombre_servicio,
    o.id_orden,
	o.nombre_orden,
    et.descripcion_etapa,
    p_rank.fecha_limite,
    p_rank.fecha_finalizacion,
    ro.nombre_empleado as supervisor,
    ro.id_empleado as id_empleado_supervisor,
    p_rank.nombre_estado_mecanizado as nombre_estado,
    th.total_horas
    from orden as o
	inner join orden_mecanizado as ot on o.id_orden = ot.id_orden
	inner join etapa as et on et.id_etapa = o.id_etapa
	inner join servicio as se on se.id_servicio = et.id_servicio
    INNER JOIN ParteRanked AS p_rank ON p_rank.id_orden = o.id_orden AND p_rank.rn = 1
    inner join Res_ord as ro on ro.id_orden = o.id_orden and ro.id_rol_empleado = 3
    inner join (SELECT  p.id_orden, SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) ) AS total_horas FROM parte p group by p.id_orden) as th on th.id_orden = o.id_orden
    order by se.prioridad_servicio;

CREATE VIEW vw_parte_trabajo AS
WITH
Res_ord AS (
	select 
		res_ord.id_orden,
		res.id_rol_empleado,
		emp.nombre_empleado,
        emp.id_empleado
	from responsabilidad_orden res_ord
	inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
	inner join empleado emp on res.id_empleado = emp.id_empleado
)
select 
	p.id_parte,
	o.nombre_orden,
	p.fecha, 
  p.fecha_limite,
  p.fecha_carga,
	e.nombre_estado as estado,
	p.horas, 
    p.observaciones,
    se.id_servicio,
    se.codigo_servicio,
    se.nombre_servicio,
    et.descripcion_etapa,
	emp.nombre_empleado as responsable,
  emp.id_empleado as id_responsable,
  ro.nombre_empleado as supervisor,
  ro.id_empleado as id_supervisor
from parte p 
inner join parte_trabajo pt on pt.id_parte = p.id_parte
inner join estado e on e.id_estado = pt.id_estado
inner join responsabilidad res on res.id_responsabilidad = p.id_responsabilidad
inner join empleado emp on emp.id_empleado = res.id_empleado
inner join orden o on o.id_orden = p.id_orden
inner join etapa et on et.id_etapa = o.id_etapa
inner join servicio se on se.id_servicio = et.id_servicio
inner join Res_ord as ro on ro.id_orden = o.id_orden and ro.id_rol_empleado = 3;

CREATE VIEW vw_parte_manufactura AS
WITH
Res_ord AS (
	select 
		res_ord.id_orden,
		res.id_rol_empleado,
		emp.nombre_empleado,
        emp.id_empleado
	from responsabilidad_orden res_ord
	inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
	inner join empleado emp on res.id_empleado = emp.id_empleado
)
select 
	p.id_parte,
	o.nombre_orden,
	p.fecha, p.fecha_limite,
	e.nombre_estado_manufactura as estado,
	p.horas,
    p.observaciones,
    se.id_servicio,
    se.codigo_servicio,
    se.nombre_servicio,
    et.descripcion_etapa,
	emp.nombre_empleado as responsable,
    emp.id_empleado as id_responsable,
    ro.nombre_empleado as supervisor,
    ro.id_empleado as id_supervisor
from parte p 
inner join parte_manufactura pt on pt.id_parte = p.id_parte
inner join estado_manufactura e on e.id_estado_manufactura = pt.id_estado_manufactura
inner join responsabilidad res on res.id_responsabilidad = p.id_responsabilidad
inner join empleado emp on emp.id_empleado = res.id_empleado
inner join orden o on o.id_orden = p.id_orden
inner join etapa et on et.id_etapa = o.id_etapa
inner join servicio se on se.id_servicio = et.id_servicio
inner join Res_ord as ro on ro.id_orden = o.id_orden and ro.id_rol_empleado = 3;


CREATE VIEW vw_parte_mecanizado AS
WITH
Res_ord AS (
	select 
		res_ord.id_orden,
		res.id_rol_empleado,
		emp.nombre_empleado,
        emp.id_empleado
	from responsabilidad_orden res_ord
	inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
	inner join empleado emp on res.id_empleado = emp.id_empleado
)
select 
	p.id_parte,
	o.nombre_orden,
	p.fecha, p.fecha_limite,
	e.nombre_estado_mecanizado as estado,
	p.horas,
    p.observaciones,
    se.id_servicio,
    se.codigo_servicio,
    se.nombre_servicio,
    et.descripcion_etapa,
	emp.nombre_empleado as responsable,
    emp.id_empleado as id_responsable,
    ro.nombre_empleado as supervisor,
    ro.id_empleado as id_supervisor
from parte p 
inner join parte_mecanizado pt on pt.id_parte = p.id_parte
inner join estado_mecanizado e on e.id_estado_mecanizado = pt.id_estado_mecanizado
inner join responsabilidad res on res.id_responsabilidad = p.id_responsabilidad
inner join empleado emp on emp.id_empleado = res.id_empleado
inner join orden o on o.id_orden = p.id_orden
inner join etapa et on et.id_etapa = o.id_etapa
inner join servicio se on se.id_servicio = et.id_servicio
inner join Res_ord as ro on ro.id_orden = o.id_orden and ro.id_rol_empleado = 3;

CREATE VIEW vw_etapa AS
  WITH 
    ActualizacionRanked AS (
      SELECT
      act_s.id_etapa,
      act_s.id_actualizacion_etapa,
      act_s.id_actualizacion,
      ROW_NUMBER() OVER (PARTITION BY act_s.id_etapa ORDER BY act_s.id_actualizacion DESC) AS rn
      FROM actualizacion_etapa AS act_s
      )
  select
    et.id_etapa, 
    se.id_servicio,
    et.descripcion_etapa, 
    case 
      when et.fecha_inicio is null then '-'
          else et.fecha_inicio
      end as fecha_inicio,
    est.id_estado,
    est.nombre_estado,
    emp.id_empleado as id_responsable,
    emp.nombre_empleado as responsable,
    case 
      when act.fecha_limite is null then '-'
          else act.fecha_limite
      end as fecha_limite,
    act.fecha_carga as fecha_ult_act,
    ObtenerFechaFinalizacionEtapa(et.id_etapa) as fecha_finalizacion,
    case
      when round(TotalCostoRealEtapa(et.id_etapa), 2) is null then 0
          else round(TotalCostoRealEtapa(et.id_etapa), 2)
      end as costo_real,
    case
      when round(TotalCostoEstimadoEtapa(et.id_etapa), 2) is null then 0
          else round(TotalCostoEstimadoEtapa(et.id_etapa), 2)
      end as costo_etimado,
    TotalHorasEstimadasEtapa(et.id_etapa) as horas_estimada,
    TotalHorasRealEtapa(et.id_etapa) as horas_real
  from etapa et
  INNER JOIN servicio se ON se.id_servicio = et.id_servicio
  INNER JOIN ActualizacionRanked AS act_se ON act_se.id_etapa = et.id_etapa AND act_se.rn = 1
  INNER JOIN actualizacion AS act ON act.id_actualizacion = act_se.id_actualizacion
  INNER JOIN estado AS est ON act.id_estado = est.id_estado
  INNER JOIN responsabilidad AS res ON et.id_responsabilidad = res.id_responsabilidad
  INNER JOIN empleado AS emp ON res.id_empleado = emp.id_empleado;


CREATE VIEW vw_gest_orden_trabajo AS
WITH 
ParteRanked AS (
    SELECT
        p.id_parte,
        pt.id_estado,
        p.fecha_limite,
        p.id_orden,
        est.nombre_estado,
        CASE
			WHEN est.id_estado = 9 THEN p.fecha
            ELSE "____-__-__"
		END as fecha_finalizacion,
        ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
    FROM parte p
    inner join parte_trabajo pt on pt.id_parte = p.id_parte
    inner join estado est on est.id_estado = pt.id_estado
),
Res_ord AS (
	select 
		res_ord.id_orden,
		res.id_rol_empleado,
		emp.nombre_empleado,
        emp.id_empleado
	from responsabilidad_orden res_ord
	inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
	inner join empleado emp on res.id_empleado = emp.id_empleado
)

select 
	se.prioridad_servicio,
    se.id_servicio,
	se.codigo_servicio,
    se.nombre_servicio,
    o.id_orden,
	o.nombre_orden,
    et.descripcion_etapa,
    p_rank.fecha_limite,
    p_rank.fecha_finalizacion,
    roo.nombre_empleado as responsable,
    roo.id_empleado as id_empleado_responsable,
    ro.nombre_empleado as supervisor,
    ro.id_empleado as id_empleado_supervisor,
    p_rank.id_estado,
    p_rank.nombre_estado,
	th.total_horas,
    round(TotalCostoEstimadoOrden(o.id_orden), 2) as costo_estimado,
    round(TotalCostoRealOrden(o.id_orden), 2) as costo_real,
    o.duracion_estimada as horas_estimada,
    TotalHorasRealOrden(o.id_orden) as horas_real
    from orden as o
	inner join orden_trabajo as ot on o.id_orden = ot.id_orden
	inner join etapa as et on et.id_etapa = o.id_etapa
	inner join servicio as se on se.id_servicio = et.id_servicio
  INNER JOIN ParteRanked AS p_rank ON p_rank.id_orden = o.id_orden AND p_rank.rn = 1
  inner join Res_ord as ro on ro.id_orden = o.id_orden and ro.id_rol_empleado = 3
  inner join Res_ord as roo on roo.id_orden = o.id_orden and roo.id_rol_empleado = 2
  inner join (SELECT  p.id_orden, SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) ) AS total_horas FROM parte p group by p.id_orden) as th on th.id_orden = o.id_orden
  order by se.prioridad_servicio;

CREATE VIEW vw_gest_orden_manufactura AS
WITH 
ParteRanked AS (
    SELECT
        p.id_parte,
        pt.id_estado_manufactura,
        p.fecha_limite,
        p.id_orden,
        est.nombre_estado_manufactura,
        CASE
			WHEN est.id_estado_manufactura = 5 THEN p.fecha
            ELSE "____-__-__"
		END as fecha_finalizacion,
        ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
    FROM parte p
    inner join parte_manufactura pt on pt.id_parte = p.id_parte
    inner join estado_manufactura est on est.id_estado_manufactura = pt.id_estado_manufactura
),
Res_ord AS (
	select 
		res_ord.id_orden,
		res.id_rol_empleado,
		emp.nombre_empleado,
        emp.id_empleado
	from responsabilidad_orden res_ord
	inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
	inner join empleado emp on res.id_empleado = emp.id_empleado
)
select 
	se.prioridad_servicio,
    se.id_servicio,
	se.codigo_servicio,
    se.nombre_servicio,
    o.id_orden,
	o.nombre_orden,
    et.descripcion_etapa,
    p_rank.fecha_limite,
    p_rank.fecha_finalizacion,
    roo.nombre_empleado as responsable,
    roo.id_empleado as id_empleado_responsable,
    ro.nombre_empleado as supervisor,
    ro.id_empleado as id_empleado_supervisor,
    p_rank.nombre_estado_manufactura as nombre_estado,
    p_rank.id_estado_manufactura as id_estado,
    th.total_horas,
    round(TotalCostoEstimadoOrden(o.id_orden), 2) as costo_estimado,
    round(TotalCostoRealOrden(o.id_orden), 2) as costo_real,
    ObtenerTotalOrdenMecxMan(ot.id_orden_manufactura) as tot_mec,
    ObtenerTotalOrdenMecxManCompleto(ot.id_orden_manufactura) as tot_mec_completo,
    case
		when ObtenerTotalOrdenMecxMan(ot.id_orden_manufactura) = 0 then 0
        else truncate((ObtenerTotalOrdenMecxManCompleto(ot.id_orden_manufactura) * 100 )/ ObtenerTotalOrdenMecxMan(ot.id_orden_manufactura), 0)
    end as tot_mec_porcentaje,
    o.duracion_estimada as horas_estimada,
    TotalHorasRealOrden(o.id_orden) as horas_real
    from orden as o
	inner join orden_manufactura as ot on o.id_orden = ot.id_orden
	inner join etapa as et on et.id_etapa = o.id_etapa
	inner join servicio as se on se.id_servicio = et.id_servicio
  INNER JOIN ParteRanked AS p_rank ON p_rank.id_orden = o.id_orden AND p_rank.rn = 1
  inner join Res_ord as ro on ro.id_orden = o.id_orden and ro.id_rol_empleado = 3
  inner join Res_ord as roo on roo.id_orden = o.id_orden and roo.id_rol_empleado = 2
  inner join (SELECT  p.id_orden, SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) ) AS total_horas FROM parte p group by p.id_orden) as th on th.id_orden = o.id_orden
  order by se.prioridad_servicio;


CREATE VIEW vw_gest_orden_mecanizado AS
WITH 
ParteRanked AS (
    SELECT
        p.id_parte,
        pt.id_estado_mecanizado,
        p.fecha_limite,
        p.id_orden,
        est.nombre_estado_mecanizado,
        CASE
			WHEN est.id_estado_mecanizado = 6 THEN p.fecha
            ELSE "____-__-__"
		END as fecha_finalizacion,
        ROW_NUMBER() OVER (PARTITION BY p.id_orden ORDER BY p.id_parte DESC) AS rn
    FROM parte p
    inner join parte_mecanizado pt on pt.id_parte = p.id_parte
    inner join estado_mecanizado est on est.id_estado_mecanizado = pt.id_estado_mecanizado
),
Res_ord AS (
	select 
		res_ord.id_orden,
		res.id_rol_empleado,
		emp.nombre_empleado,
        emp.id_empleado
	from responsabilidad_orden res_ord
	inner join responsabilidad res on res.id_responsabilidad = res_ord.id_responsabilidad
	inner join empleado emp on res.id_empleado = emp.id_empleado
)

select 
	se.prioridad_servicio,
    se.id_servicio,
	se.codigo_servicio,
    se.nombre_servicio,
    o.id_orden,
	o.nombre_orden,
    et.descripcion_etapa,
    p_rank.fecha_limite,
    p_rank.fecha_finalizacion,
    roo.nombre_empleado as responsable,
    roo.id_empleado as id_empleado_responsable,
    ro.nombre_empleado as supervisor,
    ro.id_empleado as id_empleado_supervisor,
    p_rank.id_estado_mecanizado as id_estado,
    p_rank.nombre_estado_mecanizado as nombre_estado,
    th.total_horas,
    round(TotalCostoEstimadoOrden(o.id_orden), 2) as costo_estimado,
    round(TotalCostoRealOrden(o.id_orden), 2) as costo_real,
    oman.id_orden_manufactura,
    case
		when oo.nombre_orden is null then '-'
        else oo.nombre_orden
    end as nombre_manufactura,
    o.duracion_estimada as horas_estimada,
    TotalHorasRealOrden(o.id_orden) as horas_real
    from orden as o
	inner join orden_mecanizado as ot on o.id_orden = ot.id_orden
	inner join etapa as et on et.id_etapa = o.id_etapa
	inner join servicio as se on se.id_servicio = et.id_servicio
    INNER JOIN ParteRanked AS p_rank ON p_rank.id_orden = o.id_orden AND p_rank.rn = 1
    inner join Res_ord as ro on ro.id_orden = o.id_orden and ro.id_rol_empleado = 3
    inner join Res_ord as roo on roo.id_orden = o.id_orden and roo.id_rol_empleado = 2
    inner join (SELECT  p.id_orden, SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) ) AS total_horas FROM parte p group by p.id_orden) as th on th.id_orden = o.id_orden
    left join orden_manufactura oman on oman.id_orden_manufactura = ot.id_orden_manufactura
    left join orden oo on oo.id_orden = oman.id_orden
    order by se.prioridad_servicio;


    CREATE VIEW vw_operaciones_de_hdr AS
    with
    ParteRanked AS (
        SELECT
            p.id_parte_ope_hdr,
            est.id_estado_hdr,
            p.id_ope_de_hdr,
            est.nombre_estado_hdr,
            res.id_empleado,
            emp.nombre_empleado,
            CASE
                WHEN est.id_estado_hdr = 3 THEN p.fecha
                ELSE "____-__-__"
            END as fecha_finalizacion,
            ROW_NUMBER() OVER (PARTITION BY p.id_ope_de_hdr ORDER BY p.id_parte_ope_hdr DESC) AS rn
        FROM parte_ope_hdr p
        inner join estado_hdr est on est.id_estado_hdr = p.id_estado_hdr
        left join responsabilidad res on res.id_responsabilidad = p.id_responsabilidad
        left join empleado emp on emp.id_empleado = res.id_empleado
    )
    select 
        se.prioridad_servicio,
        se.codigo_servicio,
        se.nombre_servicio,
        et.descripcion_etapa,
        o.nombre_orden,
        hdr.id_hoja_de_ruta,
        op.nombre_operacion,
        maq.codigo_maquinaria,
        op_hdr.id_ope_de_hdr,
        op_hdr.activo,
        op_hdr.numero,
        p_rank.id_estado_hdr,
        p_rank.nombre_estado_hdr,
        p_rank.nombre_empleado as ultimo_res,
        th.total_horas
    from servicio se
    inner join etapa et on et.id_servicio = se.id_servicio
    inner join orden o on o.id_etapa = et.id_etapa
    inner join orden_mecanizado om on om.id_orden = o.id_orden
    inner join hoja_de_ruta hdr on hdr.id_orden_mecanizado = om.id_orden_mecanizado
    inner join operaciones_de_hdr op_hdr on op_hdr.id_hoja_de_ruta = hdr.id_hoja_de_ruta
    inner join operacion op on op.id_operacion = op_hdr.id_operacion
    inner join ParteRanked AS p_rank ON p_rank.id_ope_de_hdr = op_hdr.id_ope_de_hdr and p_rank.rn = 1
    left join empleado emp on emp.id_empleado = p_rank.id_empleado
    inner join maquinaria maq on maq.id_maquinaria = op_hdr.id_maquinaria
    inner join (SELECT  p.id_ope_de_hdr, SEC_TO_TIME( SUM( TIME_TO_SEC( `horas` ) ) ) AS total_horas FROM parte_ope_hdr p group by p.id_ope_de_hdr) as th on th.id_ope_de_hdr = op_hdr.id_ope_de_hdr;
