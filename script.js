let projects = [];
let currentProjectIndex = -1;
let currentTaskIndex = -1;

document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    fetch('register_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Usuario registrado exitosamente');
            document.getElementById('register').style.display = 'none';
            document.getElementById('login').style.display = 'block';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error al registrar el usuario: ' + error.message);
    });
});

document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('loginUsername').value;
    const password = document.getElementById('loginPassword').value;
    const user = JSON.parse(localStorage.getItem('user'));
    if (user && user.username === username && user.password === password) {
        alert('Inicio de sesión exitoso');
        document.getElementById('login').style.display = 'none';
        document.getElementById('dashboard').style.display = 'block';
    } else {
        alert('Credenciales incorrectas');
    }
});

document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function() {
        document.getElementById('register').style.display = 'none';
        document.getElementById('login').style.display = 'none';
        document.getElementById('dashboard').style.display = 'none';
        
        const target = this.getAttribute('href').substring(1);
        document.getElementById(target).style.display = 'block';
    });
});

// Mostrar la página de registro al inicio
document.getElementById('register').style.display = 'block';

// Manejo de proyectos
document.getElementById('saveProjectBtn').addEventListener('click', function() {
    const projectName = document.getElementById('projectName').value;
    const projectDesc = document.getElementById('projectDesc').value;
    const newProject = {
        titulo: projectName,
        objetivo: projectDesc,
        n_tareas: 0,
        responsable: 1,
        n_colaboradores: 0,
        tasks: [] // Inicializa la lista de tareas
    };

    fetch('save_project.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(newProject)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Proyecto creado exitosamente');
            updateProjectList();
        } else {
            alert('Error: ' + data.message);
        }
    });
});
function updateProjectList() {
    fetch('get_projects.php')
    .then(response => response.json())
    .then(data => {
        projects = data;
        const projectList = document.getElementById('projectList');
        projectList.innerHTML = '';

        projects.forEach((project, index) => {
            const li = document.createElement('li');
            li.className = 'list-group-item';
            li.innerHTML = `
                <strong>${project.titulo}</strong>
                <p>${project.objetivo}</p>
                <button class="btn btn-info btn-sm" onclick="editProject(${index})">Modificar</button>
                <button class="btn btn-danger btn-sm" onclick="deleteProject(${index})">Eliminar</button>
                <button class="btn btn-secondary btn-sm" onclick="showTasks(${index})">Ver Tareas</button>
                <div id="tasks-${index}" style="display: none;">
                    <h5>Tareas</h5>
                    <ul class="list-group"></ul>
                    <button class="btn btn-success btn-sm" onclick="addTask(${index})">Añadir Tarea</button>
                </div>
            `;
            projectList.appendChild(li);
        });
    });
}
