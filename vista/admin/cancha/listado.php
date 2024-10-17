<?php
require_once "modelo/tipoDeporte.php"; // Asegúrate de que el modelo para TipoDeporte esté cargado

$tipoDeporteModel = new TipoDeporte();
$tiposDeDeporte = $tipoDeporteModel->listar();
require "vista/admin/menu.php"
?>
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
    border-collapse: separate;
    /* Para aplicar el efecto de sombra */
}

/* Estilo para encabezados de tabla */
.table th,
.table td {
    padding: 15px;
    text-align: center;
    border: none;
    /* Sin bordes para una apariencia limpia */
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
    border-bottom: 3px solid rgba(255, 255, 255, 0.2);
    /* Línea sutil */
}

/* Estilo para filas */
.table tbody tr {
    transition: background-color 0.3s, transform 0.3s;
}

.table tbody tr:hover {
    background: rgba(255, 87, 51, 0.4);
    /* Color de fondo suave en hover */
    transform: scale(1.02);
    /* Efecto de zoom */
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
    background: linear-gradient(90deg, #548C2F, #5aa800);
    /* Gradiente */
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s, transform 0.3s;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.table .action-links a:hover {
    background: linear-gradient(90deg, #0056b3, #007bff);
    transform: translateY(-2px);
    /* Efecto de elevación */
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
                        <p class="h1">Lista de Canchas</p>
                    </blockquote>
                </figure>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insertdata">
                    Nuevo
                </button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>STATUS</th>
                            <th>NOMBRE</th>
                            <th>PRECIO POR HORA</th>
                            <th>ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datos as $v): ?>
                        <tr>
                            <td><?php echo $v->disponibilidad ?></td>
                            <td><?php echo $v->nombre ?></td>
                            <td><?php echo $v->precio ?></td>
                            <td class="action-links">
                                <a href="#" class="btn btn-secondary edit-data" data-id="<?php echo $v->cancha_id ?>"
                                    data-toggle="modal" data-target="#editdata">Editar</a>
                                <a href="#" class="btn btn-danger eliminar"
                                    data-id="<?php echo $v->cancha_id ?>">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Insertar -->
<div class="modal fade" id="insertdata" data-backdrop="insertdata" data-keyboard="false" tabindex="-1"
    aria-labelledby="insertdataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="insertdataLabel">Insertar Nueva Cancha</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Formulario que contendrá los datos -->
            <form action="<?php echo urlsite; ?>?page=cancha&opcion=insertar" method="POST"
                enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="txtnombre">Nombre</label>
                        <input type="text" required name="txtnombre" id="txtnombre" placeholder="Nombre"
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="txtprecio">Precio</label>
                        <input type="number" required name="txtprecio" id="txtprecio" placeholder="Precio"
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="txttipodeporte">Tipo de Deporte</label>
                        <select name="txttipodeporte" id="txttipodeporte" required class="form-control">
                            <option value="">Seleccione el Tipo de Deporte</option>
                            <?php foreach ($tiposDeDeporte as $deporte): ?>
                            <option value="<?php echo $deporte->tipo_deporte_id; ?>"><?php echo $deporte->nombre; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="txtdisponibilidad">Disponibilidad</label>
                        <input type="text" required name="txtdisponibilidad" id="txtdisponibilidad"
                            placeholder="Disponibilidad" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="urlfoto">Imagen</label>
                        <input type="file" required name="urlfoto" id="urlfoto" class="form-control-file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Editar -->
<div class="modal fade" id="editdata" data-backdrop="editdata" data-keyboard="false" tabindex="-1"
    aria-labelledby="editdataLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-custom ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editdataLabel">Editar</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Formulario que contendrá los datos -->
            <form action="<?php echo urlsite; ?>?page=cancha&opcion=editar" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" required name="nombre" id="nombre" placeholder="Nombre" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" required name="precio" id="precio" placeholder="Precio"
                            class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="tipodeporte">Tipo de Deporte</label>
                        <select name="tipodeporte" id="tipodeporte" required class="form-control">
                            <!-- Opciones que se rellenarán dinámicamente -->
                            <?php foreach ($tiposDeDeporte as $deporte): ?>
                            <option value="<?php echo $deporte->tipo_deporte_id; ?>"><?php echo $deporte->nombre; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="disponibilidad">Disponibilidad</label>
                        <input type="text" required name="disponibilidad" id="disponibilidad"
                            placeholder="Disponibilidad" class="form-control">
                    </div>

                    <input type="hidden" id="id" name="id" value="<?php echo $datos[0]->cancha_id ?>">

                    <!-- Imagen actual -->
                    <div class="form-group">
                        <label>Imagen Actual</label>
                        <img id="imagenActual" src="" class="img-fluid" alt="Imagen Actual" width="200">

                    </div>

                    <div class="form-group">
                        <label for="urlfoto">Cambiar Imagen</label>
                        <input type="file" name="urlfoto" id="urlfoto" class="form-control-file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="update_data" class="btn btn-success">Actualizar</button>
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
        var canchaId = $(this).data('id'); // Obtener el ID de la cancha

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
                    '<?php echo urlsite; ?>?page=cancha&opcion=eliminar&cancha_id=' + canchaId;
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
$(document).ready(function() {
    $('.edit-data').on('click', function() {
        var canchaId = $(this).data('id'); // Obtener el ID de la cancha

        // Llamamos al backend usando AJAX para obtener los datos de la cancha
        $.ajax({
            url: '<?php echo urlsite; ?>?page=cancha&opcion=obtenerCanchaPorId',
            method: 'POST',
            dataType: 'json', // Esperamos una respuesta JSON
            data: {
                'click_view_btn': true,
                'cancha_id': canchaId,
            }, // Pasar el ID de la cancha al controlador
            success: function(response) {
                // Depuración para ver los datos recibidos
                // Asignar los datos a los campos del modal
                $('#nombre').val(response.nombre); // Nombre de la cancha
                $('#precio').val(response.precio); // Precio de la cancha
                $('#disponibilidad').val(response.disponibilidad); // Disponibilidad
                $('#id').val(response.cancha_id); // ID de la cancha

                // Asignar el tipo de deporte en el select
                $('#tipodeporte').val(response.tipo_deporte_id);

                // Cargar la imagen actual de la cancha
                $('#imagenActual').attr('src', 'public/img/instalaciones/' + response
                    .urlfoto);

                // Mostrar el modal
                $('#editdata').modal('show');
            },


            error: function(xhr, status, error) {
                console.error('Error al obtener los datos:', error);
            }
        });
    });
});
</script>