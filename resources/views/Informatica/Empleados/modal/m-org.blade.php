<style>
  #orgChartContainer {
    max-height: 400px; /* Ajusta la altura máxima si es necesario */
    overflow-y: auto; /* Permite el desplazamiento vertical si es necesario */
  }
</style>
<!-- Modal HTML -->
<div class="modal fade" id="orgChartModal" tabindex="-1" aria-labelledby="orgChartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orgChartModalLabel">Organigrama</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="orgChartContainer" style="width: 100%; height: 100%;"></div>
      </div>
      <div class="modal-footer m-auto">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
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

    let jsonData = @json($datosOrganigrama);

    jsonData.forEach(row => data.addRows([
      [{ v: String(row.id), f: String(row.nombre)}, String(row.supervisor)]
    ]));

    const chart = new google.visualization.OrgChart(document.getElementById('orgChartContainer'));
    chart.draw(data, { allowHtml: true });
  }
</script>


