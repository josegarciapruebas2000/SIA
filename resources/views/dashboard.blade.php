@extends('base')

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    @import url(https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css);
    @import url(https://fonts.googleapis.com/css?family=Raleway:400,500,800);

    figure.snip1321 {
        font-family: 'Raleway', Arial, sans-serif;
        position: relative;
        overflow: hidden;
        margin: 40px auto;
        /* Cambiado para centrar automáticamente */
        min-width: 230px;
        max-width: 315px;
        width: 100%;
        color: #000000;
        text-align: center;
        -webkit-perspective: 50em;
        perspective: 50em;
    }

    figure.snip1321 * {
        -webkit-box-sizing: padding-box;
        box-sizing: padding-box;
        -webkit-transition: all 0.2s ease-out;
        transition: all 0.2s ease-out;
    }

    figure.snip1321 img {
        max-width: 100%;
        vertical-align: top;
    }

    figure.snip1321 figcaption {
        top: 50%;
        left: 20px;
        right: 20px;
        position: absolute;
        opacity: 0;
        z-index: 1;
        transition: all 0.2s ease-out;
    }

    figure.snip1321 h2,
    figure.snip1321 h4 {
        margin: 0;
    }

    figure.snip1321 h2 {
        font-weight: 600;
    }

    figure.snip1321 h4 {
        font-weight: 400;
        text-transform: uppercase;
    }

    figure.snip1321 i {
        font-size: 32px;
    }

    figure.snip1321:after {
        background-color: #ffffff;
        position: absolute;
        content: "";
        display: block;
        top: 20px;
        left: 20px;
        right: 20px;
        bottom: 20px;
        transition: all 0.4s ease-in-out;
        transform: rotateX(-90deg);
        transform-origin: 50% 50%;
        opacity: 0;
    }

    figure.snip1321 a {
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        position: absolute;
        z-index: 1;
    }

    figure.snip1321:hover figcaption,
    figure.snip1321.hover figcaption {
        transform: translateY(-50%);
        opacity: 1;
        transition-delay: 0.2s;
    }

    figure.snip1321:hover:after,
    figure.snip1321.hover:after {
        transform: rotateX(0);
        opacity: 0.9;
    }

    .snip1321 figcaption {
        padding: 20px;
        text-align: center;
    }

    .snip1321 h4 {
        margin-bottom: 15px;
        font-size: 1.2em;
        color: #333;
    }

    .button-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .button-fixed-width {
        width: 200px;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        border-radius: 5px;
        /* Agregar radio de borde */
        border: 1px solid #ccc;
        /* Agregar borde */
        background-color: #fff;
        /* Color de fondo */
        padding: 8px;
        /* Espaciado interno */
        cursor: pointer;
    }

    .button-container {
        text-align: center;
    }

    .button-link {
    display: inline-block;
    width: 200px;
    height: 40px;
    line-height: 40px;
    background-color: rgba(0, 8, 44, 255);
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px;
    transition: background-color 0.3s, border 0.3s; /* Agregamos la propiedad 'border' a la transición */
}

.button-link:hover {
    background-color: white;
    color: #212529;
    border: 2px solid rgb(0, 0, 0); /* Añadimos un borde de 2px sólido de color negro al hacer hover */
}


</style>

@section('content')
    <div class="container">
        <div class="row justify-content-center"> <!-- Alinea horizontalmente las columnas -->
            <div class="col-md-4 col-sm-6">
                <figure class="snip1321">
                    <div style="position: relative; display: inline-block;">
                        <img src="img/modulogastos.jpg" alt="sq-sample26"
                            style="border-radius: 8px; height: 400px; width: 100%; filter: brightness(50%);" />
                        <div
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white; font-size: 24px; font-family: 'Helvetica', sans-serif;">
                            GASTOS
                        </div>
                    </div>

                    <figcaption>
                        <i class="ion-ios-calculator-outline"></i>
                        <h4>Gastos</h4>
                        <br>
                        <div class="button-container">
                            <div class="button-link" onclick="window.location.href='/autorizar'">Autorización</div>
                            <div class="button-link" onclick="window.location.href='/solicitud'">Solicitud de viáticos</div>
                            <div class="button-link" onclick="window.location.href='/comprobaciones'">Comprobación</div>
                            <div class="button-link" onclick="window.location.href='/reposicion'">Reposición</div>
                            <button class="button-link" onclick="window.location.href='/historial'">Historial de
                                gasto</button>
                        </div>
                    </figcaption>

                </figure>
            </div>

            <div class="col-md-4 col-sm-6">
                <figure class="snip1321">
                    <div style="position: relative; display: inline-block;">
                        <img src="img/modulocompras.png" alt="sq-sample26"
                            style="border-radius: 8px; height: 400px; width: 100%; filter: brightness(50%);" />
                        <div
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white; font-size: 24px; font-family: 'Helvetica', sans-serif;">
                            COMPRAS
                        </div>
                    </div>
                    <figcaption>
                        <i class="ion-ios-cart-outline"></i>
                        <h4>Compras</h4>
                        <br>
                        <div class="button-container">
                            <button class="button-fixed-width">Alta de proveedores</button>
                            <button class="button-fixed-width">Cotizaciones</button>
                            <button class="button-fixed-width">Orden de pago</button>
                            <button class="button-fixed-width">Pago de proveedor</button>
                            <button class="button-fixed-width">Cargo de pago</button>
                            <button class="button-fixed-width">Historial de compras</button>
                        </div>
                    </figcaption>
                    <a href="#"></a>
                </figure>
            </div>

            <div class="col-md-4 col-sm-6">
                <figure class="snip1321">
                    <div style="position: relative; display: inline-block;">
                        <img src="img/modulogastos.jpg" alt="sq-sample26"
                            style="border-radius: 8px; height: 400px; width: 100%; filter: brightness(50%);" />
                        <div
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white; font-size: 24px; font-family: 'Helvetica', sans-serif;">
                            ALMACEN
                        </div>
                    </div>

                    <figcaption>
                        <i class="ion-ios-box-outline"></i>
                        <h4>Almacen</h4>
                        <br>
                        <div class="button-container">
                            <button class="button-fixed-width">SEG</button>
                            <button class="button-fixed-width">Papelería</button>
                            <button class="button-fixed-width">Herramientas</button>
                            <button class="button-fixed-width">Autos</button>
                            <button class="button-fixed-width">Equipos de computo</button>
                            <button class="button-fixed-width">Entrada y salida</button>
                        </div>
                    </figcaption>
                    <a href="#"></a>
                </figure>
            </div>
        </div>

    </div>
@endsection


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mensaje de confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('success') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Bootstrap (jQuery primero, luego Popper.js y finalmente Bootstrap JS) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        @if(session()->has('success'))
            $('#exampleModal').modal('show');
        @endif
    });

    /* Demo purposes only */
    $(".hover").mouseleave(
        function() {
            $(this).removeClass("hover");
        }
    );
</script>
