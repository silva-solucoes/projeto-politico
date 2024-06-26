@php
    // Verifica se o usuário está logado
    if (!Auth::check()) {
        // Redireciona para a página de login se não estiver logado
        header('Location: ' . URL::to('/login'));
        exit(); // Encerra o script para evitar que o restante da página seja carregado
    }
@endphp
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>BORALAJEAR | Painel Administrativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesdesign" name="author">

    <link href="{{  asset('img/elemento.ico') }}" rel="icon">
    <link href="{{  asset('img/elemento.ico') }}" rel="apple-touch-icon">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <link href="{{  asset('css/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css">
    <link href="{{  asset('css/morris.css') }}" rel="stylesheet">
    <link href="{{  asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{  asset('css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{  asset('css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <link href="{{  asset('css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{  asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            text-align: center;
            color: #333;
        }

        .chart-container {
            width: 100%;
            margin: 20px 0;
        }

        .suggestions-container {
            margin: 20px 0;
        }

        #suggestionsList {
            list-style-type: none;
            padding: 0;
        }

        #suggestionsList li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        #suggestionsList li:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .logout-button {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body data-sidebar="dark" data-bs-theme="dark">

    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('img/admin/logo-oficial.png') }}" alt="logo-sm-dark" height="26">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('img/admin/logo-oficial.png') }}" alt="logo-dark" height="24">
                            </span>
                        </a>
                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('img/admin/logo-oficial.png') }}" alt="logo-sm-light" height="26">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('img/admin/logo-oficial.png') }}" alt="logo-light" height="24">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="bi bi-list align-middle"></i>
                    </button>
                </div>
                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bi bi-search"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="mb-3 m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="ri-search-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="{{ asset('img/admin/8388392.png') }}"
                                alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->name }}</span>
                            <i class="bi bi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i class="bi bi-person align-middle me-1"></i> Minha
                                conta</a>
                            <div class="dropdown-divider"></div>
                            <!-- Link de logout usando form POST (recomendado) -->
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-power align-middle me-1 text-danger"></i> Sair
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>

                        <li>
                            <a href="{{ url('/dashboard') }}" class="waves-effect">
                                <i class="bi bi-speedometer2"></i>
                                <span>Painel</span>
                            </a>
                        </li>

                        <li class="menu-title">Páginas</li>

                        <li>
                            <a href="javascript:void(0);" class="has-arrow waves-effect">
                                <i class="bi bi-lightbulb"></i>
                                <span>Sugestões</span>
                                <i class="bi bi-chevron-down"
                                    style="margin-left: 2vw; transition: transform 0.2s ease; font-size: 1rem;"></i>
                                <!-- Ícone de seta para baixo -->
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="#">Lista de Sugestões</a></li>
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#backupModal2">Exportar Dados</a>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-title">Banco de Dados</li>

                        <li>
                            <a href="#" class="waves-effect" data-bs-toggle="modal" data-bs-target="#backupModal">
                                <i class="bi bi-cloud-download"></i>
                                <span>Backup do Banco</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- Modal1 -->
        <div class="modal fade" id="backupModal" tabindex="-1" aria-labelledby="backupModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="backupModalLabel"><i class="bi bi-cloud-download"></i> Backup do
                            Banco de Dados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="text-align: justify;">
                        Você está prestes a iniciar um backup completo do banco de dados. Este processo garantirá que
                        todas as informações importantes armazenadas no sistema sejam copiadas de forma segura e
                        preservadas.<br><br>Deseja continuar?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form id="backupForm" method="POST" action="{{ route('backup.perform') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary" id="confirmBackup">Sim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal2 -->
        <div class="modal fade" id="backupModal2" tabindex="-1" aria-labelledby="backupModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="backupModalLabel"><i class="bi bi-file-earmark-excel"></i> Exportar
                            Dados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="text-align: justify;">
                        Você está prestes a exportar os dados em um arquivo Excel. Este processo criará uma cópia de
                        todos os registros em formato CSV, que poderá ser usado para análise, backup ou outras
                        necessidades.
                        <ul>
                            <li><strong>Formato do Arquivo:</strong> O arquivo será salvo no formato .xlsx, compatível
                                com a maioria dos softwares de planilha eletrônica, como Microsoft Excel e Google
                                Sheets.</li>
                            <li><strong>Localização do Arquivo:</strong> O arquivo exportado será salvo no diretório de
                                downloads padrão do seu navegador.</li>
                        </ul>
                        Deseja continuar?
                    </div>
                    <div class="modal-footer">
                        <form id="csvForm" action="{{ route('sugestao.csv') }}" method="GET">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Sim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
        <!-- Conteúdo da sua página dashboard -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Início do conteúdo da página -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 titulos">Painel</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="guiaPagina"><a href="javascript:void(0);">Bora Lajear</a><i
                                                class="bi bi-chevron-right ms-auto"></i></li>
                                        <li class="guiaPagina active">Painel</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Título da página -->

                    <div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h4 class="card-title text-muted">Coleta de Hoje</h4>
                                    <h2 class="mt-3 mb-2">
                                        @if ($dados['registrosHoje'] > 0)
                                            <i
                                                class="bi bi-arrow-up-circle text-success me-2"></i><b>{{ $dados['registrosHoje'] }}</b>
                                        @else
                                            <i class="bi bi-dash-circle text-warning me-2"></i><b>0</b>
                                        @endif
                                    </h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="card text-center">
                                <div class="card-body p-t-10">
                                    <h4 class="card-title text-muted mb-0">Total de Submissões</h4>
                                    <h2 class="mt-3 mb-2"><i
                                            class="bi bi-check-circle text-primary me-2"></i><b>{{ $dados['totalRegistros'] }}</b>
                                    </h2>
                                    <p class="text-muted mb-0 mt-3"><b>{{ $dados['porcentagemTexto'] }}</b> dos
                                        registros foram feitos nas últimas 24 horas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Estatísticas -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 card-title">Gráfico</h4>
                                    <div class="chart-container">
                                        <canvas id="suggestionsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Gráfico -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-h-100">
                                <div class="card-body">
                                    <h4 class="mb-4 mt-0 card-title">Categorias</h4>

                                    {{-- Exemplo de exibição de categorias --}}
                                    @if (isset($categorias))

                                        @foreach ($categorias as $categoria)
                                            @php
                                                $porcentagemTurismo = ($dados['totalRegistros'] > 0) ? ($dados[$categoria] / $dados['totalRegistros']) * 100 : 0;
                                                $porcentagemTexto = sprintf("%.2f%%", $porcentagemTurismo);
                                            @endphp
                                            
                                            <p class="font-600 mb-1">{{ strtoupper($categoria) }} <span class="text-primary float-end"><b>{{ $porcentagemTexto }}</b></span></p>
                                            <div class="progress mb-3">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="{{ $porcentagemTurismo }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $porcentagemTexto }};"></div></div>
                                        @endforeach
                                    @else
                                        <p>Nenhuma categoria encontrada.</p>
                                    @endif
                                    {{-- Fim do exemplo --}}

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Categorias -->

                </div> <!-- container-fluid -->
            </div> <!-- page-content -->
        </div> <!-- main-content-->
        

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Todos os direitos reservados.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Desenvolvido por <i class="bi bi-heart-fill text-danger"></i> Pedro Henrique da Silva
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center px-3 py-4 shadow">
                <h5 class="m-0 me-2">Settings</h5>
                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="{{ asset('assets/images/layouts/layout-1.jpg') }}" class="img-fluid img-thumbnail"
                        alt="layout-1">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('assets/images/layouts/layout-2.jpg') }}" class="img-fluid img-thumbnail"
                        alt="layout-2">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch"
                        data-bsStyle="{{ asset('css/bootstrap-dark.min.css') }}"
                        data-appStyle="{{ asset('css/app-dark.min.css') }}">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('assets/images/layouts/layout-3.jpg') }}" class="img-fluid img-thumbnail"
                        alt="layout-3">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch"
                        data-appStyle="{{ asset('css/app-rtl.min.css') }}">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>
            </div>
        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <script>
        $(document).ready(function () {
            // Dados do PHP para JavaScript
            let labels = @json($dados['labels']);
            let counts = @json($dados['counts']);

            const ctx = document.getElementById('suggestionsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Categorias',
                        data: counts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

    </script>

    <script>
        $('#confirmBackup').on('click', function () {
            $.ajax({
                url: $('#backupForm').attr('action'), // Verifique se a URL está correta
                type: 'POST', // Certifique-se de que o método seja POST
                data: $('#backupForm').serialize(),
                success: function (response) {
                    $('#backupModal').modal('hide');
                },
                error: function (xhr, status, error) {
                    alert('Erro ao realizar o backup: ' + error);
                }
            });
        });
    </script>

    <script>
        document.getElementById('csvForm').addEventListener('submit', function () {
            // Fechar o modal
            $('#backupModal2').modal('hide');
        });
    </script>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/waves.min.js') }}"></script>

    <!-- morris chart -->
    <script src="{{ asset('js/morris.min.js') }}"></script>
    <script src="{{ asset('js/raphael.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('js/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('js/jquery-jvectormap-us-merc-en.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/index.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>