<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;
$collectionUsuariosProyectos = $client->Quantum->usuarios_proyectos;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

$userId = $_SESSION['user_id'];
$userObjectId = new MongoDB\BSON\ObjectId($userId);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $titulo = $_POST['titulo'] ?? 'Sin título';
    $descripcion = $_POST['descripcion'] ?? 'Sin descripción';
    $etiqueta = $_POST['profesion'] ?? 'Sin etiqueta';
    
    // Obtener los colaboradores del input oculto
    $colaboradores = json_decode($_POST['colaboradores'] ?? '[]', true);
    $n_colaboradores = count($colaboradores); // Número de colaboradores

    // Crear el nuevo proyecto
    $nuevoProyecto = [
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'etiqueta' => $etiqueta,
        'n_tareas' => 0,
        'n_colaboradores' => $n_colaboradores, // Asigna el número de colaboradores
        'responsable' => $userObjectId // Almacenar el ObjectId del usuario como responsable
    ];

    // Insertar el nuevo proyecto en la colección
    $resultado = $collectionProyectos->insertOne($nuevoProyecto);
    $proyectoId = $resultado->getInsertedId();

    // Crear el registro en la colección usuarios_proyectos para el encargado
    $collectionUsuariosProyectos->insertOne([
        'id_user' => $userObjectId,
        'id_proyecto' => $proyectoId
    ]);

    // Crear registros en la colección usuarios_proyectos para cada colaborador
    foreach ($colaboradores as $colaboradorId) {
        $collectionUsuariosProyectos->insertOne([
            'id_user' => new MongoDB\BSON\ObjectId($colaboradorId),
            'id_proyecto' => $proyectoId
        ]);
    }

    // Redirigir a la página de proyectos después de crear el nuevo proyecto
    header("Location: proyectos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registrar nuevo Proyecto</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container register">
        <div class="row">
            <div class="col-md-9 register-right">
                <form action="new_project.php" method="POST">
                    <h3 class="register-heading">Registrar nuevo Proyecto</h3>
                    <div class="row register-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="titulo" placeholder="Título" required />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="descripcion" placeholder="Descripción" required />
                            </div>
                            <div class="form-group">
                                <label for="profesion">Etiqueta:</label>
                                <select class="form-control" name="profesion" id="profesion" required>
                                    <option value="" disabled selected>Seleccione una etiqueta</option>
                                    <option value="Scrum">Scrum</option>
                                    <option value="Hogar">Hogar</option>
                                    <option value="Personal">Personal</option>
                                    <option value="Trabajo">Trabajo</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="buscarColaborador">Buscar Colaborador:</label>
                                <input type="text" class="form-control" id="buscarColaborador" placeholder="Nombre del colaborador" onkeyup="buscarColaboradores()" />
                                <ul id="resultadosBusqueda" class="list-group mt-2"></ul>
                            </div>
                            <div class="form-group">
                                <label>Colaboradores seleccionados:</label>
                                <ul id="colaboradoresSeleccionados" class="list-group"></ul>
                                <input type="hidden" name="colaboradores" id="colaboradores" />
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Crear proyecto" />
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function buscarColaboradores() {
            var nombre = document.getElementById('buscarColaborador').value;
            if (nombre.length > 2) {
                fetch('buscar_usuarios.php?nombre=' + nombre)
                    .then(response => response.json())
                    .then(data => {
                        var resultados = document.getElementById('resultadosBusqueda');
                        resultados.innerHTML = '';
                        data.forEach(usuario => {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = usuario.nombre;
                            li.onclick = function() {
                                agregarColaborador(usuario._id, usuario.nombre);
                            };
                            resultados.appendChild(li);
                        });
                    });
            }
        }

        function agregarColaborador(id, nombre) {
            var listaColaboradores = document.getElementById('colaboradoresSeleccionados');
            var li = document.createElement('li');
            li.className = 'list-group-item';
            li.textContent = nombre + ' (ID: ' + id + ')';
            listaColaboradores.appendChild(li);

            var colaboradoresInput = document.getElementById('colaboradores');
            var colaboradoresSeleccionados = colaboradoresInput.value ? JSON.parse(colaboradoresInput.value) : [];
            if (!colaboradoresSeleccionados.includes(id)) {
                colaboradoresSeleccionados.push(id);
            }
            colaboradoresInput.value = JSON.stringify(colaboradoresSeleccionados);
        }
    </script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
