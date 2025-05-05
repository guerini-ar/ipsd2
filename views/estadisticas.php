<?php // ========================================================================= ?>
        <?php // --- ARCHIVO SUGERIDO: views/estadisticas.php --- ?>
        <?php // <?php require 'views/estadisticas.php'; ?>
        <?php // ========================================================================= ?>
        <div class="p-3">
            <h2 class="mb-4">Panel de Estadísticas</h2>
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center dashboard-card h-100">
                        <div class="card-body">
                            <div style="height: 50%;">
                                <div class="stat-number"><?php echo $stat_total_alumnos; ?></div>
                                <h5 class="card-title">Alumnos Registrados</h5>
                            </div>
                             <hr style="width: 80%; margin: 0.5rem auto;">
                            <div class="stat-gender-split" style="height: 50%;">
                                <div class="female">
                                    <i class="bi bi-gender-female"></i>
                                    <strong><?php echo $stat_total_mujeres_general; ?></strong>
                                </div>
                                <div class="male">
                                     <i class="bi bi-gender-male"></i>
                                     <strong><?php echo $stat_total_varones_general; ?></strong>
                                </div>
                            </div>
                        </div>
                         <div class="card-footer text-muted">
                            <a href="index.php?accion=leer" class="btn btn-sm btn-outline-primary">Ver Listado</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center dashboard-card h-100">
                        <div class="card-body dashboard-cursos-nivel">
                             <i class="bi bi-layers-fill text-success fs-1 mb-2"></i>
                             <h5 class="card-title mb-1">Cursos</h5>
                             <ul class="mt-2">
                                 <li>Total Únicos: <strong><?php echo $stat_total_cursos; ?></strong></li>
                                 <li>Inicial (I): <strong><?php echo $stat_cursos_inicial; ?></strong></li>
                                 <li>Primario (P): <strong><?php echo $stat_cursos_primario; ?></strong></li>
                                 <li>Secundario (S): <strong><?php echo $stat_cursos_secundario; ?></strong></li>
                             </ul>
                        </div>
                         <div class="card-footer text-muted">
                            <small>Distribución por nivel</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                     <div class="card text-center dashboard-card h-100">
                        <div class="card-body">
                             <div id="graficoAlumnosNivelContainer">
                                <canvas id="graficoAlumnosNivel"></canvas>
                             </div>
                             <h5 class="card-title mt-2">Alumnos por Nivel</h5>
                        </div>
                         <div class="card-footer text-muted">
                            <small>Distribución de alumnos</small>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-3 col-md-6"></div> <?php // Columna vacía ?>
            </div>

            <div class="row g-4">
                <div class="col-lg-12">
                     <div class="card h-100">
                         <div class="card-header">
                             Distribución de Género por Curso
                         </div>
                         <div class="card-body">
                             <?php if (!empty($datos_grafico_genero_curso)): ?>
                                 <div class="chart-container">
                                     <canvas id="graficoGeneroCurso"></canvas>
                                 </div>
                             <?php else: ?>
                                 <p class="text-muted text-center">No hay datos suficientes para mostrar el gráfico.</p>
                             <?php endif; ?>
                         </div>
                     </div>
                </div>
            </div>
        </div>
        <?php // ========================================================================= ?>
        <?php // --- FIN ARCHIVO SUGERIDO: views/estadisticas.php --- ?>
        <?php // ========================================================================= ?>