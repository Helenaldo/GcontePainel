<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gconte Painel</title>
    <!-- Inclua o CSS do Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%; /* Necessário para o flex container ocupar toda a altura */
            margin: 0; /* Remove a margem padrão */
        }
        .flex-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .content {
            flex: 1; /* Faz com que o conteúdo expanda para preencher o espaço disponível, empurrando o rodapé para baixo */
        }
        .header {
            background-color: #e2e7ed; /* Azul do Bootstrap */
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .footer {
            background-color: #6c757d; /* Cinza do Bootstrap */
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .titulo, .image {
            text-align: center; /* Centraliza o conteúdo */
            margin-top: 20px;
        }
        .image img {
            max-height: 60vh; /* Limita a altura da imagem */
            width: auto; /* Mantém a proporção da imagem */
        }
    </style>
</head>
<body>
    <div class="flex-wrapper">
        <div class="header d-flex justify-content-between align-items-center" style="padding: 0 20px;">
            <img src="image/logo-gconte.png" alt="Logo GCONTE" style="height: 50px;"> <!-- Logo GCONTE -->
            <a href="{{ route('admin') }}" class="btn btn-outline-dark">Login</a> <!-- Botão Login alinhado à direita -->
        </div>

        <div class="content">
            <div class="titulo">
                <h1>GCONTE PAINEL</h1>
                <p>Sistema de controle de Processos do Escritório de Contabilidade <br> <a href="http://www.gconte.com.br" target="_blank" class="btn btn-link" rel="noopener noreferrer" style="color: black;">GCONTE GESTÃO CONTÁBIL E EMPRESARIAL</a></p>
                {{-- <address>Rua Treze de Maio, 1114, Vermelha, Teresina-PI, CEP 64.018-285</address> --}}
            </div>
            <div class="image">
                <img src="image/construcao.png" alt="Página em Construção" class="img-fluid">
            </div>
        </div>
        <div class="footer">
            2024. Desenvolvido por <a href="http://www.helenaldo.com.br/" target="_blank" style="color: white;">Helenaldo Carvalho</a>
        </div>
    </div>
    <!-- Opcional: Inclua o JS do Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
