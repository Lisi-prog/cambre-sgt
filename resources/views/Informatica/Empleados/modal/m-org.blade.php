<!-- Modal HTML -->
<div class="modal fade" id="orgChartModal" tabindex="-1" aria-labelledby="orgChartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orgChartModalLabel">Organigrama</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="orgChartContainer" style="width: 100%; height: 400px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Código para generar el organigrama -->
<script type="text/javascript">
  google.charts.load('current', { packages: ['orgchart'] });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    const data = new google.visualization.DataTable();
    data.addColumn('string', 'Name');
    data.addColumn('string', 'Manager');
    data.addColumn('string', 'ToolTip');

    // Datos del organigrama (Nombre, Supervisor, Tooltip)
    data.addRows([
      // (Nombre, Supervisor, Descripción o Tooltip)
      [{ v: '1', f: 'Juan Pérez<div style="color:red; font-style:italic">Supervisor</div>' }, '', 'CEO'],
      [{ v: '2', f: 'Carlos García<div style="color:blue; font-style:italic">Supervisor</div>' }, '1', 'Jefe de Tecnología'],
      [{ v: '3', f: 'María López<div style="color:green; font-style:italic">Supervisor</div>' }, '1', 'Jefa de Finanzas'],
      [{ v: '4', f: 'Ana Martínez<div style="color:purple; font-style:italic">Supervisor</div>' }, '1', 'Jefa de Operaciones'],
      [{ v: '5', f: 'Luis Fernández<div>Tecnología</div>' }, '2', 'Desarrollador'],
      [{ v: '6', f: 'Elena Gómez<div>Contabilidad</div>' }, '3', 'Contadora'],
      [{ v: '7', f: 'Jorge Ramírez<div>Operaciones</div>' }, '4', 'Gerente de Operaciones']
    ]);

    const chart = new google.visualization.OrgChart(document.getElementById('orgChartContainer'));
    chart.draw(data, { allowHtml: true });
  }
</script>


