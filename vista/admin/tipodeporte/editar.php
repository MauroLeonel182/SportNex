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
    width: 600px;
}

.titulo {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
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
}

.img-fluid {
        width: 100%;
        height: auto;
        display: block;
        max-width: 400px; /* Max width of the image container */
        max-height: 400px; /* Max height of the image container */
        object-fit: cover; /* Ensure the image covers the container */
        border: 1px solid #ddd;
        border-radius: 4px;
        margin: 0 auto 15px auto; /* Center the image horizontally */
    }

.mensaje {
    color: red;
    text-align: center;
    margin-top: 15px;
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

</style>
<div id="contenedorr">
    <div id="central">
        <div id="login">
            <div class="titulo">Actualizar Información</div>
            <form id="loginform" action="<?php echo urlsite ?>?page=deportes&opcion=editar" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label for="txtnombre">Nombre</label>
                    <input type="text" required name="txtnombre" id="txtnombre" value="<?php echo $datos[0]->nombre ?>" placeholder="Nombre">
                </div>

                <input type="hidden" name="txtid" value="<?php echo $datos[0]->tipo_deporte_id ?>">
                <div class="form-group">
                    <input type="submit" class="btn-primary" value="ACTUALIZAR" name="btnactualizar">
                </div>
                <div class="navback">
                    <a href="javascript:history.back()">Volver</a>
                </div>
            </form>
            <p class="mensaje"><?php echo (isset($_GET['msg'])) ? $_GET['msg'] : "" ?></p>
        </div>
    </div>
</div>

