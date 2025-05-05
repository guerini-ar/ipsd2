<?php // ========================================================================= ?>
        <?php // --- ARCHIVO SUGERIDO: views/estructura_sistema.php --- ?>
        <?php // <?php require 'views/estructura_sistema.php'; ?>
        <?php // ========================================================================= ?>
        <div class="p-3">
            <h2 class="mb-4">Estructura de Archivos Sugerida</h2>
            <div class="card">
                <div class="card-body">
                    <pre><code class="language-plaintext">
/ (Raíz del proyecto)
│
├── config/
│   └── database.php        # Credenciales de la BBDD
│
├── includes/               # Utilidades, configuración general
│   ├── db_connection.php   # Conexión a BBDD
│   ├── init.php            # Inicialización (sesión, constantes, etc.)
│   └── helpers.php         # Funciones auxiliares
│
├── actions/                # Scripts para procesar formularios/acciones
│   ├── login_process.php   # Lógica POST login
│   ├── logout.php          # Lógica logout
│   ├── alumno_crear.php    # Lógica POST crear alumno
│   ├── alumno_actualizar.php # Lógica POST actualizar alumno
│   ├── alumno_eliminar.php # Lógica eliminar alumno
│   ├── usuario_crear.php   # Lógica POST crear usuario
│   └── exportar.php        # Lógica exportación CSV/TXT
│
├── templates/              # Plantillas HTML (o 'views')
│   ├── header.php          # Cabecera HTML, navbar
│   ├── footer.php          # Pie de página HTML, scripts JS
│   ├── inicio.php          # Vista: Página de inicio pública
│   ├── estadisticas.php    # Vista: Panel de estadísticas (admin)
│   ├── administracion.php  # Vista: Panel de administración (admin)
│   ├── estructura_sistema.php # Vista: Estructura de archivos (admin)
│   └── alumnos/            # Vistas específicas de alumnos
│       ├── list.php        # Vista: Tabla de alumnos
│       └── form.php        # Vista: Formulario crear/editar alumno
│   └── usuarios/           # Vistas específicas de usuarios
│       └── form_crear.php  # Vista: Formulario crear usuario
│
├── index.php               # Controlador frontal principal
└── login.php               # Página de login
                    </code></pre>
                </div>
            </div>
        </div>
        <?php // ========================================================================= ?>
        <?php // --- FIN ARCHIVO SUGERIDO: views/estructura_sistema.php --- ?>
        <?php // ========================================================================= ?>