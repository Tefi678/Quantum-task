<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;
$collectionUsuariosProyectos = $client->Quantum->usuarios_proyectos;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userObjectId = new MongoDB\BSON\ObjectId($userId);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? 'Sin título';
    $descripcion = $_POST['descripcion'] ?? 'Sin descripción';
    $etiqueta = $_POST['profesion'] ?? 'Sin etiqueta';
    
    // Validar y decodificar la entrada 'colaboradores'
    $colaboradoresJson = $_POST['colaboradores'] ?? '[]';
    $colaboradores = json_decode($colaboradoresJson, true);

    // Comprobar si el resultado decodificado es un array
    if (!is_array($colaboradores)) {
        $colaboradores = []; // Volver a un array vacío
    }

    // Convertir los IDs de usuario a ObjectId
    $colaboradoresObjectIds = array_map(function($id) {
        return new MongoDB\BSON\ObjectId($id);
    }, $colaboradores);

    $n_colaboradores = count($colaboradoresObjectIds);
    
    $nuevoProyecto = [
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'etiqueta' => $etiqueta,
        'n_tareas' => 0,
        'n_colaboradores' => $n_colaboradores,
        'responsable' => $userObjectId,
        'colaboradores' => $colaboradoresObjectIds,
        'fecha_creacion' => date('Y-m-d H:i:s'),
        'imagen' => 'images/atom.png'
    ];

    $resultado = $collectionProyectos->insertOne($nuevoProyecto);
    $proyectoId = $resultado->getInsertedId();

    $collectionUsuariosProyectos->insertOne([
        'id_user' => $userObjectId,
        'id_proyecto' => $proyectoId
    ]);

    foreach ($colaboradoresObjectIds as $colaboradorObjectId) {
        $collectionUsuariosProyectos->insertOne([
            'id_user' => $colaboradorObjectId,
            'id_proyecto' => $proyectoId
        ]);
    }

    header("Location: proyectos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style4.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registrar nuevo Proyecto</title>
    <?php include 'header.php'; ?>
</head>
<body class="bg-theme-color-light">
    <div class="container register">
        <div class="row justify-content-center">
            <div class="col-md-9 register-right">
                <form action="new_project.php" method="POST">
                    <h3 class="register-heading text-center">Registrar nuevo Proyecto</h3>
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
                        </div>
                        <div class="col-md-6">
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
                    <div class="row justify-content-center">
                        <input type="submit" class="btn btn-primary btn-lg" value="Crear proyecto" />
                    </div>
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
