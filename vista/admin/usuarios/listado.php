<?php require "vista/admin/menu.php"?>
<style>
body {
    background-color: #121212;
    margin: 0;
    padding: 0;
    justify-content: center;
    align-items: flex-start;
}

.container-fluid {
    padding: 20px;
}

/* Cuando el menú está visible, el contenido está desplazado */
.content-menu-visible {
    margin-left: 240px;
    background-color: #121212;
}

/* Cuando el menú está oculto, el contenido se desplaza a la izquierda */
.content-menu-hidden {
    margin-left: 60px;
}

/* Ajustes para el botón "Nuevo" */
.btn {
    padding: 10px 15px;
    background-color: #e53e3e;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: bold;
    text-transform: uppercase;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.btn:hover {
    background-color: #ff5733;
    transform: translateY(-2px);
}

/* Estilo para la tabla */
.table {
    width: 100%;
    background-color: rgba(0, 0, 0, 0.85);
    margin-top: 20px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
    border-collapse: separate; /* Para aplicar el efecto de sombra */
}

/* Estilo para encabezados de tabla */
.table th,
.table td {
    padding: 15px;
    text-align: center;
    border: none; /* Sin bordes para una apariencia limpia */
    white-space: nowrap;
    color: white;
    position: relative;
    transition: background-color 0.3s, transform 0.3s;
}

/* Encabezados */
.table thead {
    background: linear-gradient(90deg, #e53e3e, #ff5733);
    color: white;
    font-weight: bold;
    text-align: center;
    border-bottom: 3px solid rgba(255, 255, 255, 0.2); /* Línea sutil */
}

/* Estilo para filas */
.table tbody tr {
    transition: background-color 0.3s, transform 0.3s;
}

.table tbody tr:hover {
    background: rgba(255, 87, 51, 0.4); /* Color de fondo suave en hover */
    transform: scale(1.02); /* Efecto de zoom */
}

/* Estilo para enlaces en la tabla */
.table a {
    text-decoration: none;
    color: #ff5733;
    font-weight: bold;
    transition: color 0.3s;
}

.table a:hover {
    color: #ff7f50;
}

/* Estilos para enlaces de acción */
.table .action-links a {
    display: inline-block;
    padding: 5px 10px;
    color: #fff;
    background: linear-gradient(90deg, #548C2F, #5aa800); /* Gradiente */
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s, transform 0.3s;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.table .action-links a:hover {
    background: linear-gradient(90deg, #0056b3, #007bff);
    transform: translateY(-2px); /* Efecto de elevación */
}

.table .action-links a.eliminar {
    background: linear-gradient(90deg, #dc3545, #c82333);
}

.table .action-links a.eliminar:hover {
    background: linear-gradient(90deg, #b82b2b, #a01d1d);
}

/* Estilos responsivos */
@media (max-width: 768px) {
    .table th,
    .table td {
        padding: 10px 15px;
        font-size: 14px;
    }

    .table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .btn {
        font-size: 14px;
        padding: 8px 16px;
    }
}

@media (max-width: 576px) {
    .btn {
        width: 100%;
        font-size: 12px;
    }

    .table th,
    .table td {
        font-size: 12px;
        padding: 6px 8px;
    }

    .container-fluid {
        padding: 10px;
    }
}

/* Estilo personalizado para el modal */
.modal-custom {
    max-width: 400px;
}
</style>


<div class="content content-menu-visible" id="content-area">
    <!-- Cambia esta clase dinámicamente con JavaScript -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <figure class="text-center">
                    <blockquote class="blockquote">
                        <p class="h1">Lista de Usuarios</p>
                    </blockquote>
                </figure>
                <table class="table">
                    <thead>
                        <tr>
                            <th>FECHA DE REGISTRO</th>
                            <th>USUARIO</th>
                            <th>EMAIL</th>
                            <th>ROL</th>
                            <th>ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datos as $v): ?>
                        <tr>
                            <td><?php echo $v->fecha_registro?> </td>
                            <td><?php echo $v->nombre_usuario ?> </td>
                            <td><?php echo $v->email ?> </td>
                            <td><?php echo $v->rol ?> </td>
                            <td class="action-links">
                                <a href="#" class="btn btn-secondary edit-data" data-id="<?php echo $v->usuario_id ?>"
                                    data-toggle="modal" data-target="#editdata">Editar</a>
                                <a href="#" class="btn btn-danger eliminar"
                                    data-id="<?php echo $v->usuario_id ?>">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Editar -->
<div class="modal fade" id="editdata" data-backdrop="editdata" data-keyboard="false" tabindex="-1"
    aria-labelledby="editdataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-custom">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editdataLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Formulario que contendrá los datos -->
            <form action="<?php echo urlsite ?>?page=usuarios&opcion=editar" enctype="multipart/form-data"
                method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre de Usuario</label>
                        <!-- El campo de nombre ahora es readonly -->
                        <input type="text" readonly name="nombre" id="nombre" placeholder="Nombre de Usuario"
                            class="form-control">

                        <label for="email">Email</label>
                        <!-- El campo de email ahora es readonly -->
                        <input type="email" readonly name="email" id="email" placeholder="Email" class="form-control">

                        <label for="rol">Rol</label>
                        <select name="rol" id="rol" class="form-control">
                            <option value="cliente">Cliente</option>
                            <option value="administrador">Administrador</option>
                        </select>
                    </div>
                    <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $datos[0]->usuario_id ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- SECCIÓN SCRIPS-->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php if (isset($_SESSION['msg'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: '<?= $_SESSION['msg'] ?>',
    showConfirmButton: true,
    timer: 1500
});
</script>
<?php unset($_SESSION['msg']); // Limpiar el mensaje después de mostrarlo ?>
<?php endif; ?>

<script>
$(document).ready(function() {
    // Interceptar clic en el botón de eliminación
    $('.eliminar').on('click', function(e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto del enlace
        var usuarioId = $(this).data('id'); // Obtener el ID del usuario

        // Mostrar el SweetAlert para confirmación
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, redirigir a la URL de eliminación
                window.location.href =
                    '<?php echo urlsite; ?>?page=usuarios&opcion=eliminar&usuario_id=' +
                    usuarioId;
            }
        });
    });


    <?php if (isset($_SESSION['msg'])): ?>
    // Mostrar el mensaje después de eliminar
    Swal.fire({
        icon: 'success',
        title: '<?= $_SESSION['msg'] ?>',
        showConfirmButton: false,
        timer: 1500
    });
    <?php unset($_SESSION['msg']); // Limpiar el mensaje después de mostrarlo ?>
    <?php endif; ?>
});
</script>

<script>
$('.edit-data').on('click', function() {
    var usuarioId = $(this).data('id'); // Cambiado a 'id'

    // Llamamos al backend usando AJAX para obtener los datos del usuario
    $.ajax({
        url: '<?php echo urlsite; ?>?page=usuarios&opcion=obtenerUsuariosPorId',
        method: 'POST',
        dataType: 'json', // Esperamos una respuesta JSON
        data: {
            'usuario_id': usuarioId // Enviar el ID correcto del usuario
        },
        success: function(response) {
            if (response.error) {
                console.error('Error en la respuesta:', response.error);
            } else {
                // Asignar los datos recibidos a los campos del modal
                $('#nombre').val(response.nombre_usuario);
                $('#email').val(response.email);
                $('#rol').val(response.rol);
                $('#usuario_id').val(response.usuario_id);
                // Mostrar el modal de edición
                $('#editdata').modal('show');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener los datos del usuario:', error);
        }
    });
});
</script>