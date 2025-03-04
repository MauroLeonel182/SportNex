<?php require "vista/admin/menu.php"?>
<style>
body {
    font-family: 'Poppins', sans-serif; /* Fuente limpia y moderna */
    background-color: #f5f5f5; /* Fondo claro */
}

#contenedorr {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

#central {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 800px;
}

.titulo {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
}

.form-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.form-left {
    flex: 1;
}

.form-right {
    flex: 1;
    text-align: center;
}

.img-fluid {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    margin-bottom: 15px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-size: 14px;
    color: #333;
    margin-bottom: 5px;
}

.form-group input[type="text"],
.form-group input[type="number"],
.form-group input[type="file"],
.form-group select {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
    outline: none;
    transition: all 0.3s ease;
}

.form-group input[type="text"]:focus,
.form-group input[type="number"]:focus,
.form-group input[type="file"]:focus,
.form-group select:focus {
    border-color: #007bff;
}

.btn-primary {
    background-color: #007bff;
    color: #ffffff;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    width: 100%;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border-radius: 4px;
}

.btn-primary:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

.navback a {
    display: inline-block;
    text-align: center;
    padding: 10px 20px;
    background-color:  #007bff; 
    color: #fff;
    width: 100%;
    font-size: 16px;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.navback a:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

.mensaje {
    color: red;
    text-align: center;
    margin-top: 15px;
}


</style>
<div id="contenedorr">
    <div id="central">
        <div id="login">
            <div class="titulo">Actualizar Información</div>
            <div class="form-container">
                <!-- Formulario a la izquierda -->
                <div class="form-left">
                    <form id="loginform" action="<?php echo urlsite ?>?page=cancha&opcion=editar" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <label for="txtnombre">Nombre</label>
                            <input type="text" required name="txtnombre" id="txtnombre" value="<?php echo $datos[0]->nombre ?>" placeholder="Nombre">
                        </div>

                        <div class="form-group">
                            <label for="txtprecio">Precio</label>
                            <input type="number" required name="txtprecio" id="txtprecio" value="<?php echo $datos[0]->precio ?>" placeholder="Precio">
                        </div>

                        <div class="form-group">
                            <label for="txttipodeporte">Tipo de Deporte</label>
                            <select name="txttipodeporte" id="txttipodeporte" required>
                                <?php foreach ($tipos_deporte as $tipo): ?>
                                    <option value="<?php echo htmlspecialchars($tipo->tipo_deporte_id); ?>" 
                                            <?php echo ($datos[0]->tipo_deporte_id == $tipo->tipo_deporte_id) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($tipo->nombre); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="txtdisponibilidad">Disponibilidad</label>
                            <input type="text" required name="txtdisponibilidad" id="txtdisponibilidad" value="<?php echo $datos[0]->disponibilidad ?>" placeholder="Disponibilidad">
                        </div>

                        <input type="hidden" name="txtid" value="<?php echo $datos[0]->cancha_id ?>">

                        <div class="form-group">
                            <input type="submit" class="btn-primary" value="ACTUALIZAR" name="btnactualizar">
                        </div>

                        <div class="navback">
                            <a href="javascript:history.back()">VOLVER</a>
                        </div>
                    </form>
                </div>

                <!-- Imagen a la derecha con "Cambiar Imagen" debajo -->
                <div class="form-right">
                    <label>Imagen Actual</label>
                    <img src="public/img/instalaciones/<?php echo $datos[0]->urlfoto ?>" class="img-fluid" alt="Imagen Actual">
                    <div class="form-group">
                        <label for="urlfoto">Cambiar Imagen</label>
                        <input type="file" name="urlfoto" id="urlfoto">
                    </div>
                </div>
            </div>

            <p class="mensaje"><?php echo (isset($_GET['msg'])) ? $_GET['msg'] : "" ?></p>
        </div>
    </div>
</div>

