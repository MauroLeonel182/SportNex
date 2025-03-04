<?php
require "vista/layouts/headerfront.php";
?>

<main class="flex-grow">
    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenido a SportNex</h1>
            <p>Tu principal destino para deportes y fitness</p>
            <button class="btn btn-primary" onclick="window.location.href='?page=instalaciones'">Instalaciones</button>
        </div>
    </section>

    <section class="instalaciones">
        <h2>Reserva Inmediata</h2>
        <div class="grid-container">
        </div>
    </section>
</main>

<?php
require_once "vista/layouts/footer.php";
?>
<style>
/* Hero section */
.hero {
    position: relative;
    height: 80vh;
    background-image: url('public/img/hero-image.jpg');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
}

.hero-content {
    text-align: center;
    color: #fff;
    position: relative;
    z-index: 1;
}

.hero h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.hero p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-primary {
    background-color: #ff4136;
    color: #fff;
}

.btn-primary:hover {
    background-color: #e60000;
}


.btn-outline {
    background-color: transparent;
    border: 1px solid #333;
    color: #333;
}

.btn-outline:hover {
    background-color: #f1f1f1;
}

.btn-white {
    background-color: #fff;
    color: #ff4136;
}

.btn-white:hover {
    background-color: #f1f1f1;
}

</style>