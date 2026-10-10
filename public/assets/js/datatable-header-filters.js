/* Shared header filters for DataTables 2, local or server-side.
 * Call from initComplete: agregarFiltrosCabecera(this.api(), {
 *   columnas: [0, 1, 2], excluirInicialmente: {2: ['Cancelado']}
 * });
 */
(function (global) {
  'use strict';
  const instancias = new WeakMap();
  let siguienteInstancia = 0;

  global.agregarFiltrosCabecera = function (tabla, opciones = {}) {
    const nodo = tabla.table().node();
    if (instancias.has(nodo)) return tabla;
    const servidor = tabla.settings()[0].oFeatures.bServerSide ? opciones.servidor : null;
    if (tabla.settings()[0].oFeatures.bServerSide && !servidor) {
      throw new Error('Configura valores y selecciones del servidor para los filtros de encabezado.');
    }
    const instancia = ++siguienteInstancia;
    const controlador = new AbortController();
    const limpiar = [];
    const excluidos = opciones.excluirInicialmente || {};
    nodo.classList.add('dt-filtros-cabecera');
    instancias.set(nodo, controlador);
    tabla.columns(opciones.columnas).every(function (indice) {
      limpiar.push(crearFiltro(this, indice, excluidos[indice] || [], instancia, controlador, servidor));
    });
    tabla.on('destroy.dt.filtrosCabecera', function () {
      controlador.abort();
      limpiar.forEach(eliminar => eliminar());
      nodo.classList.remove('dt-filtros-cabecera');
      instancias.delete(nodo);
    });
    if (!servidor) tabla.draw();
    return tabla;
  };

function crearFiltro(columna, indice, excluidos, instancia, controlador, servidor) {
  const escuchar = (elemento, evento, callback, capture = false) =>
    elemento.addEventListener(evento, callback, {capture, signal: controlador.signal});
  const cabecera = columna.header();
  const titulo = cabecera.textContent.trim();
  const tabla = columna.table();
  // Use displayed text: DOM rows contain HTML and search data can lose accents.
  const texto = html => {
    const contenedor = document.createElement('div');
    contenedor.innerHTML = String(html ?? '');
    return contenedor.textContent.replace(/\s+/g, ' ').trim();
  };
  const valoresPorFila = new Map();
  if (!servidor) columna.cells(null, indice).every(function () {
    valoresPorFila.set(this.index().row, texto(this.render('display')));
  });
  const valores = Array.from(new Set(servidor ? servidor.valores[indice] || [] : valoresPorFila.values())).sort((a, b) =>
    String(a).localeCompare(String(b), 'es', {numeric: true}));
  let seleccion = new Set(valores.filter(valor => !excluidos.includes(valor)));
  const boton = document.createElement('button');
  boton.type = 'button';
  boton.className = 'dt-filtro-boton';
  boton.textContent = '▼';
  boton.setAttribute('aria-label', `Filtrar ${titulo}`);
  boton.setAttribute('aria-expanded', 'false');
  boton.setAttribute('aria-controls', `dt-filtro-${instancia}-${indice}`);
  (cabecera.querySelector('.dt-column-title') || cabecera).append(boton);

  const menu = document.createElement('section');
  menu.id = `dt-filtro-${instancia}-${indice}`;
  menu.className = 'dt-filtro-menu';
  menu.hidden = true;
  menu.setAttribute('aria-label', `Filtro de ${titulo}`);
  menu.innerHTML = `<strong></strong>
    <input class="dt-filtro-buscar" type="search" placeholder="Buscar valores…" aria-label="Buscar valores">
    <label class="dt-filtro-todos"><input type="checkbox"> Seleccionar todos los visibles</label>
    <div class="dt-filtro-valores"></div><p class="dt-filtro-vacio" hidden>Sin coincidencias</p>
    <div class="dt-filtro-acciones"><button type="button" class="dt-filtro-limpiar">Limpiar</button>
    <button type="button" class="dt-filtro-aplicar">Aplicar</button></div>`;
  menu.querySelector('strong').textContent = titulo;
  document.body.append(menu);
  const buscar = menu.querySelector('.dt-filtro-buscar');
  const todos = menu.querySelector('.dt-filtro-todos input');
  const lista = menu.querySelector('.dt-filtro-valores');
  let borrador;
  let visibles = valores;

  function dibujar() {
    const consulta = buscar.value.toLocaleLowerCase('es');
    visibles = valores.filter(valor => String(valor).toLocaleLowerCase('es').includes(consulta));
    lista.replaceChildren();
    visibles.forEach(valor => {
      const etiqueta = document.createElement('label');
      const casilla = document.createElement('input');
      casilla.type = 'checkbox';
      casilla.checked = borrador.has(valor);
      casilla.addEventListener('change', () => {
        if (casilla.checked) borrador.add(valor);
        else borrador.delete(valor);
        actualizarTodos();
      });
      etiqueta.append(casilla, document.createTextNode(String(valor)));
      lista.append(etiqueta);
    });
    menu.querySelector('.dt-filtro-vacio').hidden = visibles.length > 0;
    actualizarTodos();
  }

  function actualizarTodos() {
    const cantidad = visibles.filter(valor => borrador.has(valor)).length;
    todos.checked = visibles.length > 0 && cantidad === visibles.length;
    todos.indeterminate = cantidad > 0 && cantidad < visibles.length;
    todos.disabled = visibles.length === 0;
  }

  function cerrar(devolverFoco = false) {
    menu.hidden = true;
    boton.setAttribute('aria-expanded', 'false');
    if (devolverFoco) boton.focus();
  }

  function aplicar(redibujar = true) {
    seleccion = new Set(borrador);
    const activo = seleccion.size !== valores.length;
    // DataTables normaliza el texto de búsqueda (por ejemplo, quita tildes).
    // Las casillas contienen los valores originales: comparar contra la fila.
    if (servidor) {
      if (activo) servidor.selecciones[indice] = { incluir: Array.from(seleccion) };
      else delete servidor.selecciones[indice];
    } else {
      columna.search(activo ? (_texto, _fila, filaIndice) => seleccion.has(valoresPorFila.get(filaIndice)) : '');
    }
    if (redibujar) tabla.draw();
    boton.classList.toggle('activo', activo);
    boton.replaceChildren();
    if (activo) {
      const icono = document.createElement('i');
      icono.className = 'fas fa-filter';
      icono.setAttribute('aria-hidden', 'true');
      boton.append(icono);
    } else {
      boton.textContent = '▼';
    }
    boton.setAttribute('aria-label', `Filtrar ${titulo}${activo ? ' (filtro activo)' : ''}`);
    cerrar(redibujar);
  }

  borrador = new Set(seleccion);
  aplicar(false);

  // El menú vive fuera de la tabla para evitar que el panel lo recorte.
  escuchar(boton, 'click', evento => {
    evento.stopPropagation();
    const abrir = menu.hidden;
    document.dispatchEvent(new Event('datatable-cerrar-filtros'));
    if (!abrir) return;
    borrador = new Set(seleccion);
    buscar.value = '';
    menu.hidden = false;
    boton.setAttribute('aria-expanded', 'true');
    dibujar();
    const rect = boton.getBoundingClientRect();
    const ancho = menu.offsetWidth;
    menu.style.left = `${Math.max(8, Math.min(rect.left, window.innerWidth - ancho - 8))}px`;
    menu.style.top = `${Math.max(8, Math.min(rect.bottom + 6, window.innerHeight - menu.offsetHeight - 8))}px`;
    buscar.focus();
  });
  escuchar(boton, 'keydown', evento => evento.stopPropagation());
  escuchar(boton, 'mousedown', evento => evento.stopPropagation());
  escuchar(buscar, 'input', dibujar);
  escuchar(todos, 'change', () => {
    visibles.forEach(valor => todos.checked ? borrador.add(valor) : borrador.delete(valor));
    dibujar();
  });
  escuchar(menu.querySelector('.dt-filtro-aplicar'), 'click', () => aplicar());
  escuchar(menu.querySelector('.dt-filtro-limpiar'), 'click', () => {
    borrador = new Set(valores);
    aplicar();
  });
  escuchar(document, 'datatable-cerrar-filtros', () => cerrar());
  escuchar(document, 'click', evento => {
    if (!menu.contains(evento.target) && !boton.contains(evento.target)) cerrar();
  });
  escuchar(document, 'keydown', evento => {
    if (evento.key === 'Escape' && !menu.hidden) cerrar(true);
  });
  // Esperar a que el clic sobre un label termine de enfocar su casilla.
  // Durante focusout, relatedTarget puede ser body aunque el clic sea interno.
  escuchar(menu, 'keydown', evento => {
    if (evento.key === 'Tab') {
      setTimeout(() => {
        if (!menu.contains(document.activeElement)) cerrar();
      }, 0);
    }
  });
  escuchar(window, 'resize', () => cerrar());
  escuchar(window, 'scroll', evento => {
    if (!menu.contains(evento.target)) cerrar();
  }, true);
  return () => { menu.remove(); boton.remove(); };
}

}(window));
