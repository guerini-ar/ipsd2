<?php // ========================================================================= ?>
<?php // --- ARCHIVO SUGERIDO: templates/footer.php --- ?>
<?php // (Contendría el footer HTML y los scripts JS) ?>
<?php // ========================================================================= ?>
<footer class="bg-dark text-white mt-5 pt-5 pb-4"> <?php // mt-5 para separar del contenido ?>
    <div class="container text-center text-md-start">
        <div class="row text-center text-md-start">

            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 fw-bold text-warning">Instituto Privado Santa Doménica</h5>
                <p>
                    Aquí puedes añadir una breve descripción del instituto, su misión, visión o algún dato relevante.
                </p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 fw-bold text-warning">Navegación</h5>
                <p><a href="index.php?accion=inicio" class="text-white" style="text-decoration: none;">Inicio</a></p>
                <?php if (isset($_SESSION['user_id'])): ?>
                     <p><a href="index.php?accion=leer" class="text-white" style="text-decoration: none;">Gestión Alumnos</a></p>
                     <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                         <p><a href="index.php?accion=estadisticas" class="text-white" style="text-decoration: none;">Estadísticas</a></p>
                         <p><a href="index.php?accion=administracion" class="text-white" style="text-decoration: none;">Administración</a></p>
                         <p><a href="index.php?accion=crear_usuario" class="text-white" style="text-decoration: none;">Crear Usuario</a></p>
                     <?php endif; ?>
                <?php endif; ?>
                <p><a href="#" class="text-white" style="text-decoration: none;">Otro Link</a></p>
            </div>

            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                 <h5 class="text-uppercase mb-4 fw-bold text-warning">Recursos</h5>
                 <p><a href="#" class="text-white" style="text-decoration: none;">Calendario Escolar</a></p>
                 <p><a href="#" class="text-white" style="text-decoration: none;">Reglamento</a></p>
                 <p><a href="#" class="text-white" style="text-decoration: none;">Noticias</a></p>
                 <p><a href="#" class="text-white" style="text-decoration: none;">Ayuda</a></p>
            </div>

             <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                 <h5 class="text-uppercase mb-4 fw-bold text-warning">Contacto</h5>
                 <p><i class="bi bi-house-door-fill me-3"></i> Dirección del Instituto, Ciudad</p>
                 <p><i class="bi bi-envelope-fill me-3"></i> info@instituto.edu.ar</p>
                 <p><i class="bi bi-telephone-fill me-3"></i> + 01 234 567 88</p>
                 <p><i class="bi bi-printer-fill me-3"></i> + 01 234 567 89</p>
             </div>
        </div>

        <hr class="mb-4">

        <div class="row align-items-center">
            <div class="col-md-7 col-lg-8">
                <p class="text-center text-md-start">
                    © <?php echo date("Y"); ?> Diseño y desarrollo por Gerardo Guerini. Todos los derechos reservados.
                </p>
            </div>
            <div class="col-md-5 col-lg-4">
                <div class="text-center text-md-end">
                    <ul class="list-unstyled list-inline">
                        <li class="list-inline-item">
                            <a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="bi bi-facebook"></i></a>
                        </li>
                         <li class="list-inline-item">
                            <a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="bi bi-twitter-x"></i></a>
                        </li>
                         <li class="list-inline-item">
                            <a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="bi bi-instagram"></i></a>
                        </li>
                         <li class="list-inline-item">
                            <a href="#" class="btn-floating btn-sm text-white" style="font-size: 23px;"><i class="bi bi-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php // ========================================================================= ?>
<?php // --- FIN ARCHIVO SUGERIDO: templates/footer.php --- ?>
<?php // ========================================================================= ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // Habilitar tooltips de Bootstrap
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Registrar el plugin de datalabels globalmente
    Chart.register(ChartDataLabels);

    <?php // --- Script para el Gráfico Género por Curso --- ?>
    <?php if (($accion == 'inicio' || $accion == 'estadisticas') && !empty($datos_grafico_genero_curso)): ?>
    const ctxGeneroCurso = document.getElementById('graficoGeneroCurso');
    if (ctxGeneroCurso) {
        const datosGraficoGenero = JSON.parse('<?php echo addslashes($json_datos_grafico_genero); ?>');
        const labelsCursos = datosGraficoGenero.map(item => item.curso);
        const datosVarones = datosGraficoGenero.map(item => parseInt(item.varones) || 0);
        const datosMujeres = datosGraficoGenero.map(item => parseInt(item.mujeres) || 0);
        const datosTotales = datosVarones.map((num, idx) => num + datosMujeres[idx]); // Calcular totales

        new Chart(ctxGeneroCurso, {
            type: 'bar',
            data: {
                labels: labelsCursos,
                datasets: [
                    {
                        label: 'Varones', data: datosVarones,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)', borderColor: 'rgba(54, 162, 235, 1)', borderWidth: 1,
                        datalabels: {
                            display: function(context) { return context.dataset.data[context.dataIndex] > 0; },
                            color: 'white', anchor: 'center', align: 'center', font: { weight: 'bold', size: 9 },
                            formatter: function(value) { return value; }
                        }
                    },
                    {
                        label: 'Mujeres', data: datosMujeres,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 1,
                        datalabels: {
                            display: function(context) { return context.dataset.data[context.dataIndex] > 0; },
                            color: 'white', anchor: 'center', align: 'center', font: { weight: 'bold', size: 9 },
                            formatter: function(value) { return value; }
                        }
                    }
                ]
            },
            plugins: [ChartDataLabels, { // Plugin para total encima
                id: 'totalSumLabels',
                afterDatasetsDraw(chart, args, options) {
                    const { ctx } = chart;
                    ctx.save();
                    ctx.font = 'bold 10px sans-serif';
                    ctx.fillStyle = '#444';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    chart.getDatasetMeta(0).data.forEach((datapoint, index) => {
                        const total = datosTotales[index];
                        if (total > 0) {
                            const x = datapoint.x;
                            const yPosition = chart.scales.y.getPixelForValue(total) - 5;
                            if (yPosition >= 10) { ctx.fillText(total, x, yPosition); }
                        }
                    });
                    ctx.restore();
                }
            }],
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    tooltip: { mode: 'index', intersect: false },
                    legend: { display: true, position: 'bottom' },
                    datalabels: { display: false } // Desactivar globalmente, se maneja por dataset/plugin
                },
                scales: {
                    x: { stacked: true },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        afterDataLimits: (scale) => { scale.max = scale.max * 1.2; } // Margen superior
                    }
                }
            }
        });
    }
    <?php endif; ?>
    <?php // --- Fin Script Gráfico Género por Curso --- ?>

    <?php // --- Script para el Gráfico Alumnos por Nivel --- ?>
    <?php if (($accion == 'inicio' || $accion == 'estadisticas') && !empty($datos_grafico_nivel)): ?>
    const ctxAlumnosNivel = document.getElementById('graficoAlumnosNivel');
     if (ctxAlumnosNivel) {
        const datosGraficoNivel = JSON.parse('<?php echo addslashes($json_datos_grafico_nivel); ?>');
        const labelsNivel = Object.keys(datosGraficoNivel);
        const dataNivel = Object.values(datosGraficoNivel);

        if (dataNivel.some(val => val > 0)) {
            new Chart(ctxAlumnosNivel, {
                type: 'pie',
                data: {
                    labels: labelsNivel,
                    datasets: [{
                        label: 'Alumnos',
                        data: dataNivel,
                        backgroundColor: [ 'rgba(255, 159, 64, 0.7)', 'rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)' ],
                        borderColor: [ 'rgba(255, 159, 64, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)' ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                             callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed !== null) { label += context.formattedValue; }
                                    return label;
                                }
                            }
                        },
                        datalabels: {
                             formatter: (value, ctx) => {
                                let sum = 0;
                                let dataArr = ctx.chart.data.datasets[0].data;
                                dataArr.map(data => { sum += data; });
                                let percentage = sum > 0 ? ((value*100 / sum).toFixed(1))+"%" : '0%';
                                return value + '\n(' + percentage + ')'; // Valor y Porcentaje
                            },
                            color: '#fff',
                            textStrokeColor: 'black',
                            textStrokeWidth: 1,
                            font: { weight: 'bold', size: 11 },
                             display: function(context) { return context.dataset.data[context.dataIndex] > 0; }
                        }
                    }
                }
            });
        } else {
             const container = document.getElementById('graficoAlumnosNivelContainer');
             if(container) container.innerHTML = '<p class="text-muted text-center mt-3">No hay datos de alumnos por nivel.</p>';
        }
    }
    <?php endif; ?>
    <?php // --- Fin Script Gráfico Alumnos por Nivel --- ?>

</script>

</body>
</html>