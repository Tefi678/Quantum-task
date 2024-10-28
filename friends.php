<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style9.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Gestor de Proyectos</title>
    <?php include 'header.php'; ?>
</head>
<body>
<div class="container">
  <div class="py-6">
    <div class="row">
      <div class="col-lg-4 col-12">
        <div class="card mb-5 rounded-3">
          <div>
            <img src="images/atom.png" alt="Image" class="img-fluid rounded-top">
          </div>
          <div class="avatar avatar-xl mt-n7 ms-4">
            <img src="images/user.png" alt="Image" class="rounded-circle border-4
              border-white-color-40">
          </div>
          <div class="card-body">
            <h4 class="mb-1">Titulo</h4>
            <p>descripcion</p>
            <p>Creado por: responsable</p>
            <p>N° de Colaboradores: n_colaboradores</p>
            <p>Crado el: fecha_creacion</p>
            <span class="badge badge-secondary">etiqueta</span>
            <div>
              <div class="d-flex justify-content-between
                align-items-center">
                <a href="#!" class="btn btn-outline-primary">Ir a proyecto</a>
                <div class="dropdown dropstart">
                  <a href="#!" class="btn btn-ghost btn-icon btn-sm rounded-circle" id="dropdownMenuOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuOne">
                  <a class="dropdown-item d-flex align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash me-2 icon-xxs dropdown-item-icon"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>Editar</a>
                    <a class="dropdown-item d-flex align-items-center" href="#!"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash me-2 icon-xxs dropdown-item-icon"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>Eliminar</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
