<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSULTA DE GUIA | TRANSPORTES JR</title>
    <link rel="stylesheet" href="css/consulta_guias.css">
    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- FONTAWESOME -->
    <script src="https://kit.fontawesome.com/1953eea880.js"></script>
    <script type="text/javascript">
        // Initialize our function when the document is ready for events.
        jQuery(document).ready(function(){
            // Listen for the input event.
            jQuery("#agh").on('input', function (evt) {
                // Allow only numbers.
                jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
            });
        });
    </script>
</head>
<body>
    <header>
        <nav>
            <div class="navContainer"> 
                <div class="logo">
                    <img src="https://i.ibb.co/yfBVM6C/Logo-7-7.png" alt="">
                </div>
                <div class="linkSection">
                    <div class="links">
                        <div class="link"><a href="https://transportesjrgt.com/index.html">Inicio</a></div>
                        <div class="link"><a href="https://transportesjrgt.com/index.html#about">Acerca de</a></div>
                        <div class="link">
                            <a href="#" class="dropdownToggle">Consultas <i class="fas fa-chevron-down"></i> <i class="fas fa-times"></i></a>
                            <div class="dropdown">
                                <div>
                                    <ul>
                                        <li><a href="consulta_guias.php">Consulta de Guías</a></li>
                                        <li><a href="https://transportesjrgt.com/contacto.html">Contáctanos</a></li>
                                        <li><a href="https://transportesjrgt.com/solicitud.html">Solicitud de Guías</a></li>
                                        <li><a href="https://transportesjrgt.com/solicitudTrabajo.html">Únetenos</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="link"><a href="https://transportesjrgt.com/crearReclamos.html">Reclamos</a></div>
                        <div class="link"><a href="https://transportesjrgt.com/index.html#ubicanos">Ubicanos</a></div>
                    </div>
                </div>
                <div class="toggle">
                    <div class="icon">
                        <i class="fas fa-bars"></i>
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <section class="formulario">
        <div class="container">
            <div class="form signup">
                <h2>Buscar Guía</h2>
                    <form action="consulta.php" method="POST">
                        <div class="inputBox">
                            <input type="text" id="agh" required="" placeholder="No. Guía" name="bodega">
                            <i class="fab fa-slack-hash"></i>
                        </div>
                        <div class="inputBox">
                            <input type="submit" value="Buscar" name="enviando">
                        </div>
                    </form>
            </div>
            <div class="form signin"></div>
        </div>
    </section>
    <section>
        <div class="footerSection">
            <div class="container">
                <h1>Formas de Contactarnos</h1>
                <div class="sections">
                    <div>
                        <h2>Contacto</h2>
                        <a href="mailto:contact@degla.com">servicioalcliente@transportesjrgt.com</a>
                        <a href="tel:+50222995900">+502 2299-5900</a>
                        <a href="tel:+50250516652">+502 5051-6652</a>
                    </div>
                    <div>
                        <h2>Central</h2>
                        <p>20 calle 2-43 Z.3</p>
                        <p>Ciudad Guatemala, 01003-Guat. City, Guatemala</p>
                    </div>
                    <div>
                        <h2>Servicio al Cliente</h2>
                        <p>Lunes a Sábado</p>
                        <p>8:00 am - 6:00 pm</p>
                    </div>
                    <div>
                        <h2>Oficinas abiertas</h2>
                        <p>Lunes a Sábado</p>
                        <p>8:00 am - 6:00 pm</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="scrollUp">
            <i class="fas fa-arrow-up"></i>
        </div>
        <div class="container">
            <div>
                <div class="links">
                    <div>
                        <a href="https://www.instagram.com/transjrgt/"><i class="fab fa-instagram"></i></a>
                    </div>
                    <div>
                        <a href="https://www.facebook.com/transportesjrgt/"><i class="fab fa-facebook"></i></a>
                    </div>
                    <div>
                        <a href="https://wa.me/50250516652?text=¡Quisiera%20comunicarme%20con%20ustedes!"><i class="fab fa-whatsapp"></i></a>
                    </div>
                    <div>
                        <a href="https://www.youtube.com/channel/UC5VKWuCNCbMdB_upOfB2Cxw"><i class="fab fa-youtube"></i></a>
                    </div>
                    <div>
                        <a href="http://tiktok.com/@transjrgt"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="js/navBar.js"></script>
</body>
</html>