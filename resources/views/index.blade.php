<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bora Lajear!</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('img/elemento.ico') }}" rel="icon">
    <link href="{{ asset('img/elemento.ico') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Verifica se existe a variável de sessão cadastro_sucesso e exibe o popup se existir
            @if (session('cadastro_sucesso'))
                var popup = document.getElementById('popup');
                popup.style.display = 'block';

                // Joga confetes ao exibir o popup
                jogarConfetes();

                {{ session()->forget('cadastro_sucesso') }} // Limpa a variável de sessão após exibir o popup
            @endif
        });

        function fecharPopup() {
            var popup = document.getElementById('popup');
            popup.style.display = 'none';
        }

        function jogarConfetes() {
            let params = {
                particleCount: 500, // Quantidade de confetes
                spread: 90, // O quanto eles se espalham
                startVelocity: 70, // Velocidade inicial
                origin: {
                    x: 0,
                    y: 0.5
                }, // Posição inicial na tela
                angle: 45 // Ângulo em que os confetes serão lançados
            };

            // Joga confetes da esquerda pra direita
            confetti(params);

            // Joga confetes da direita para a esquerda
            params.origin.x = 1;
            params.angle = 135;
            confetti(params);
        }
    </script>



    <style>
        .video-section {
            position: relative;
            width: 100%;
            max-width: 100%;
            height: auto;
            overflow: hidden;
        }

        .video-placeholder {
            width: 100%;
            height: auto;
        }
    </style>

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top" style="display: none;">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <nav id="navmenu" class="navmenu">
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <main class="main">
        <!-- Estrutura do popup -->
        <div id="popup" class="popup">
            <div class="popup-content">
                <span class="close" onclick="fecharPopup()">&times;</span>
                <div style="text-align: center;">
                    <img src="{{ asset('img/visto.gif') }}" alt="Ícone de Visto"
                        style="width: 15vw; height: 15vw; margin-bottom: 20px;">
                </div>
                <h2><span class="parabens">Recebemos sua sugestão com sucesso!</span></h2>
                <p><span class="agradecemos">Agradecemos pela sua contribuição.</span></p>
            </div>
        </div>
        <!-- Hero Section -->
        <section id="hero" class="hero imgFundo section">
            <div class="container text-center">
                <div class="row gy-4 ajustarIMG">
                    <div class="img-bg col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center"
                        data-aos="zoom-out">
                        <!--<p><span class="highlight">BORA</span>LAJEAR!</p>-->
                    </div>
                </div>
                <section class="intro-text text-center container mt-4 mb-4">
                    <h1>QUEREMOS OUVIR AS SUAS IDEIAS E SUGESTÕES<br> PARA A NOSSA CIDADE.</h1>
                    <p>Participe e contribua com o nosso plano de governo.</p>
                </section>
                <section class="video-section">
                    <video controls class="video-placeholder">
                        <source src="{{ asset('video/vídeo-bora-lajear.mp4') }}" type="video/mp4">
                        Seu navegador não suporta o elemento de vídeo.
                    </video>
                </section>
            </div>
        </section><!-- /Hero Section -->

        <!-- Call To Action Section -->
        <section id="call-to-action" class="call-to-action section">
            <div class="container">
                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-xl-9 text-center text-xl-start" style="text-align: center;">
                        <h1 class="titulo">AQUI O PLANO É NOSSO.<br>E NOSSO PLANO É CONSTRUIR<br> LAJES JUNTO COM VOCÊ.
                            <p class="subtitulo">Deixe sua contribuição para o nosso plano de governo.</p>
                        </h1>
                    </div>
                    <div class="col-xl-3 cta-btn-container text-center">
                        <a class="cta-btn align-middle" href="#contact">BORALAJEAR!</a>
                    </div>
                </div>
            </div>
        </section><!-- /Call To Action Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2><b>Não deixe sua voz se perder no silêncio.</b> Sua participação é mais do que um direito; é um
                    dever.<br>Junte-se a nós e seja parte da história.</h2>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-12">
                        <form action="{{ url('/paginas/forms') }}" method="post" class="php-email-form"
                            data-aos="fade-up" data-aos-delay="200">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-12">
                                    <label for="name-field" class="pb-2">Nome (Opcional)</label>
                                    <input type="text" name="name" id="name-field" class="form-control"
                                        placeholder="Seu nome">
                                    <small class="form-text text-muted">Seu nome é opcional, caso não queira se
                                        identificar.</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="subject-field" class="pb-2">Telefone/Whatsapp (Opcional)</label>
                                    <input type="text" class="form-control" name="telefone" id="telefone-field"
                                        placeholder="(84) 00000-0000">
                                    <small class="form-text text-muted">Seu telefone/Whatsapp é opcional, mas útil para
                                        que possamos entrar em contato, se necessário.</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="email-field" class="pb-2">E-mail (Opcional)</label>
                                    <input type="email" class="form-control" name="email" id="email-field"
                                        placeholder="Seu e-mail">
                                    <small class="form-text text-muted">Seu e-mail é opcional, mas útil caso precisemos
                                        esclarecer sua sugestão.</small>
                                </div>

                                <div class="col-md-12">
                                    <label for="category-field" class="pb-2">Selecione a área relacionada à sua sugestão
                                        *</label>
                                    <select class="form-control" name="category" id="category-field" required>
                                        <option value="" disabled selected>Escolha uma opção</option>
                                        <option value="turismo-cultura-meio-ambiente">TURISMO, CULTURA E MEIO AMBIENTE
                                        </option>
                                        <option value="saude">SAÚDE</option>
                                        <option value="educacao">EDUCAÇÃO</option>
                                        <option value="administracao-seguranca-publica">ADMINISTRAÇÃO E SEGURANÇA
                                            PÚBLICA</option>
                                        <option value="transportes-mobilidade-urbana">TRANSPORTES E MOBILIDADE URBANA
                                        </option>
                                        <option value="juventude-esporte-lazer">JUVENTUDE, ESPORTE E LAZER</option>
                                        <option value="infraestrutura-servicos-urbanos">INFRAESTRUTURA E SERVIÇOS
                                            URBANOS</option>
                                        <option value="agricultura">AGRICULTURA</option>
                                        <option value="economia">ECONOMIA</option>
                                        <option value="social-trabalho-habitacao">SOCIAL, TRABALHO E HABITAÇÃO</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="message-field" class="pb-2">Sugestões para o Plano de Governo *</label>
                                    <textarea class="form-control" name="message" rows="10" id="message-field" required
                                        placeholder="Sua sugestão"></textarea>
                                </div>

                                <div class="col-md-12 d-flex align-items-center">
                                    <input type="checkbox" id="agree-checkbox" name="termo" class="me-2" required>
                                    <label for="agree-checkbox" style="text-align: justify;">Ao preencher este
                                        formulário, você concorda com o uso de seus dados pessoais de acordo com a LGPD
                                        (Lei Geral de Proteção de Dados). Seus dados serão usados apenas para os fins
                                        relacionados a esta consulta e não serão compartilhados com terceiros sem
                                        autorização. Ao clicar em enviar, você confirma que leu e concorda com nossos
                                        termos de Uso e Política de Privacidade.</label>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">Carregando</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Sua sugestão foi enviada. Obrigado!</div>

                                    <button type="submit">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->

    </main>

    <footer id="footer" class="footer">
        <div class="container copyright text-center mt-4">
            <p>FELIPE MENEZES | PRÉ-CANDIDATO A PREFEITO</p>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const video = document.querySelector('.video-placeholder');
            const playButton = document.getElementById('playButton');

            if (video) {
                // Tenta iniciar a reprodução do vídeo com som
                video.muted = false; // Garantir que o vídeo não esteja silenciado
                video.volume = 1.0; // Definir o volume para o máximo

                video.play().then(() => {
                    console.log('Vídeo está tocando com som.');
                }).catch(error => {
                    console.error('Erro ao tentar reproduzir o vídeo com som:', error);
                    // Exibir o botão de reprodução se a reprodução automática falhar
                    playButton.style.display = 'block';
                });

                // Adicionar um evento de clique ao botão para iniciar a reprodução do vídeo
                playButton.addEventListener('click', function () {
                    video.play().then(() => {
                        console.log('Vídeo está tocando com som após interação do usuário.');
                        playButton.style.display = 'none'; // Ocultar o botão após a reprodução
                    }).catch(error => {
                        console.error('Erro ao tentar reproduzir o vídeo após interação do usuário:', error);
                    });
                });
            }
        });
    </script>
</body>

</html>