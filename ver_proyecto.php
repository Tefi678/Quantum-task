<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;
$collectionUsuariosProyectos = $client->Quantum->usuarios_proyectos;

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

// Obtener el ID del proyecto desde la URL
if (!isset($_GET['id']) || !preg_match('/^[0-9a-f]{24}$/', $_GET['id'])) {
    echo "ID de proyecto inválido.";
    exit();
}

$proyectoId = new MongoDB\BSON\ObjectId($_GET['id']);

// Obtener el proyecto
$proyecto = $collectionProyectos->findOne(['_id' => $proyectoId]);
if (!$proyecto) {
    echo "Proyecto no encontrado.";
    exit();
}

// Obtener colaboradores del proyecto
$colaboradores = $collectionUsuariosProyectos->find(['id_proyecto' => $proyectoId]);

// Eliminar proyecto
if (isset($_POST['eliminar'])) {
    // Eliminar el proyecto de la colección
    $collectionProyectos->deleteOne(['_id' => $proyectoId]);
    
    // Eliminar las asociaciones de usuarios_proyectos
    $collectionUsuariosProyectos->deleteMany(['id_proyecto' => $proyectoId]);
    
    // Redirigir a la página de proyectos después de eliminar
    header("Location: proyectos.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style6.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Detalles del Proyecto</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container mt-4">
        <h3><?= htmlspecialchars($proyecto['titulo']) ?></h3>
        <p><strong>Descripción:</strong> <?= htmlspecialchars($proyecto['descripcion']) ?></p>
        <p><strong>Etiqueta:</strong> <?= htmlspecialchars($proyecto['etiqueta']) ?></p>
        <p><strong>Responsable:</strong> <?= htmlspecialchars($proyecto['responsable']) ?></p>
        <p><strong>Número de Tareas:</strong> <?= htmlspecialchars($proyecto['n_tareas']) ?></p>
        <p><strong>Número de Colaboradores:</strong> <?= htmlspecialchars($proyecto['n_colaboradores']) ?></p>
    </div>
    <div class="task-box">
        <h1>Tareas</h1>

        <div class="tabs">
            <div class="tab active" onclick="showTab('add')">Añadir Tarea</div>
            <div class="tab" onclick="showTab('view')">Ver Tareas</div>
            <div class="tab" onclick="showTab('modify')">Modificar Tarea</div>
            <div class="tab" onclick="showTab('delete')">Eliminar Tarea</div>
        </div>

        <div class="content">

            <div id="add" class="task-form">
                <form id="taskForm">
                    <label for="taskName">Nombre de la tarea</label>
                    <input type="text" id="taskName" required>

                    <label for="description">Descripción</label>
                    <textarea id="description" rows="3" required></textarea>

                    <label for="responsible">Responsable</label>
                    <input type="text" id="responsible" required>

                    <label for="dueDate">Fecha límite</label>
                    <input type="date" id="dueDate" required>

                    <label for="priority">Prioridad</label>
                    <select id="priority" required>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>

                    <label for="status">Estado</label>
                    <select id="status" required>
                        <option value="Pendiente">Pendiente</option>
                        <option value="En progreso">En progreso</option>
                        <option value="Completada">Completada</option>
                    </select>

                    <div class="buttons">
                        <button type="button" class="add-task" onclick="addTask()">Añadir Tarea</button>
                    </div>
                </form>
            </div>

            <div id="view" class="task-list hidden">
                <h2>Lista de Tareas</h2>
                <table id="taskTable">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Responsable</th>
                            <th>Fecha Límite</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se insertarán las tareas -->
                    </tbody>
                </table>
                <div class="buttons">
                    <button onclick="displayTasks()">Actualizar Lista</button>
                </div>
            </div>

            <div id="modify" class="task-list hidden">
                <h2>Modificar Tarea</h2>
                <label for="modifyIndex">Índice de la tarea a modificar:</label>
                <input type="number" id="modifyIndex" min="0" required>
                <button onclick="loadTask()">Cargar Tarea</button>

                <div id="modifyForm" class="hidden">
                    <form>
                        <label for="modifyTaskName">Nombre de la tarea</label>
                        <input type="text" id="modifyTaskName" required>

                        <label for="modifyDescription">Descripción</label>
                        <textarea id="modifyDescription" rows="3" required></textarea>

                        <label for="modifyResponsible">Responsable</label>
                        <input type="text" id="modifyResponsible" required>

                        <label for="modifyDueDate">Fecha límite</label>
                        <input type="date" id="modifyDueDate" required>

                        <label for="modifyPriority">Prioridad</label>
                        <select id="modifyPriority" required>
                            <option value="Baja">Baja</option>
                            <option value="Media">Media</option>
                            <option value="Alta">Alta</option>
                        </select>

                        <label for="modifyStatus">Estado</label>
                        <select id="modifyStatus" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En progreso">En progreso</option>
                            <option value="Completada">Completada</option>
                        </select>

                        <div class="buttons">
                            <button type="button" class="modify-task" onclick="modifyTask()">Modificar Tarea</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="delete" class="task-list hidden">
                <h2>Eliminar Tarea</h2>
                <label for="deleteIndex">Índice de la tarea a eliminar:</label>
                <input type="number" id="deleteIndex" min="0" required>
                <button onclick="deleteTask()">Eliminar Tarea</button>
            </div>

        </div>
    </div>

    <script>
        let tasks = [];

        function showTab(tab) {
            const tabs = document.querySelectorAll('.content > div');
            tabs.forEach(t => {
                t.classList.add('hidden');
            });
            document.getElementById(tab).classList.remove('hidden');

            const tabButtons = document.querySelectorAll('.tab');
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });
            document.querySelector(`.tab:contains(${tab.charAt(0).toUpperCase() + tab.slice(1)})`).classList.add('active');
        }

        function addTask() {
            const taskName = document.getElementById('taskName').value;
            const description = document.getElementById('description').value;
            const responsible = document.getElementById('responsible').value;
            const dueDate = document.getElementById('dueDate').value;
            const priority = document.getElementById('priority').value;
            const status = document.getElementById('status').value;

            tasks.push({
                name: taskName,
                description: description,
                responsible: responsible,
                dueDate: dueDate,
                priority: priority,
                status: status
            });

            document.getElementById('taskForm').reset();
            displayTasks();
        }

        function displayTasks() {
            const tableBody = document.getElementById('taskTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = '';
            tasks.forEach((task, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${task.name}</td>
                    <td>${task.description}<span class="tooltip">${task.description}</span></td>
                    <td>${task.responsible}</td>
                    <td>${task.dueDate}</td>
                    <td>${task.priority}</td>
                    <td>${task.status}</td>
                    <td>
                        <button class="delete-task" onclick="deleteTask(${index})">Eliminar</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function loadTask() {
            const index = document.getElementById('modifyIndex').value;
            if (index >= 0 && index < tasks.length) {
                const task = tasks[index];
                document.getElementById('modifyTaskName').value = task.name;
                document.getElementById('modifyDescription').value = task.description;
                document.getElementById('modifyResponsible').value = task.responsible;
                document.getElementById('modifyDueDate').value = task.dueDate;
                document.getElementById('modifyPriority').value = task.priority;
                document.getElementById('modifyStatus').value = task.status;
                document.getElementById('modifyForm').classList.remove('hidden');
            } else {
                alert('Índice no válido');
            }
        }

        function modifyTask() {
            const index = document.getElementById('modifyIndex').value;
            if (index >= 0 && index < tasks.length) {
                tasks[index] = {
                    name: document.getElementById('modifyTaskName').value,
                    description: document.getElementById('modifyDescription').value,
                    responsible: document.getElementById('modifyResponsible').value,
                    dueDate: document.getElementById('modifyDueDate').value,
                    priority: document.getElementById('modifyPriority').value,
                    status: document.getElementById('modifyStatus').value
                };
                displayTasks();
                document.getElementById('modifyForm').classList.add('hidden');
                document.getElementById('modifyIndex').value = '';
            } else {
                alert('Índice no válido');
            }
        }

        function deleteTask(index) {
            if (index !== undefined) {
                tasks.splice(index, 1);
            } else {
                const deleteIndex = document.getElementById('deleteIndex').value;
                if (deleteIndex >= 0 && deleteIndex < tasks.length) {
                    tasks.splice(deleteIndex, 1);
                } else {
                    alert('Índice no válido');
                }
            }
            displayTasks();
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
