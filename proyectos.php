<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro</title>
    <?php include 'header.html'; ?>
</head>
<body>
    <div id="dashboard" class="container mt-5" style="display: none;">
        <h2>Panel de Administración</h2>
        <h3>Proyectos</h3>
        <button class="btn btn-success" id="addProjectBtn">Añadir Proyecto</button>
        <ul id="projectList" class="list-group mt-3"></ul>

        <div class="modal" id="projectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Añadir/Modificar Proyecto</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="projectName">Nombre del Proyecto</label>
                            <input type="text" class="form-control" id="projectName" required>
                        </div>
                        <div class="form-group">
                            <label for="projectDesc">Descripción</label>
                            <textarea class="form-control" id="projectDesc" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="saveProjectBtn">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para tareas -->
        <div class="modal" id="taskModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Añadir/Modificar Tarea</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="taskName">Nombre de la Tarea</label>
                            <input type="text" class="form-control" id="taskName" required>
                        </div>
                        <div class="form-group">
                            <label for="taskDesc">Descripción</label>
                            <textarea class="form-control" id="taskDesc" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="taskResponsible">Responsable</label>
                            <input type="text" class="form-control" id="taskResponsible" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="saveTaskBtn">Guardar Tarea</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
