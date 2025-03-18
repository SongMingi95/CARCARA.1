<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="../css/adm.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        
        <div class="header">
            <!-- Botão de logout -->
           <!-- Botão de logout -->
<button class="logout-btn" onclick="window.location.href='logout.php'"><i class="fa-solid fa-right-from-bracket"></i> SAIR</button>

        </div>

        <div class="content">
            <h1>Painel do Administrador</h1>
            <div class="actions">
                <!-- Botões para ação do administrador -->
                <button class="cadastrar-btn">Cadastrar Evento</button>
                <button class="editar-btn">Editar Evento</button>
                <!-- Botão que leva para a página de eventos organizados por tipo -->
                <button class="visualizar-btn">Visualizar Eventos</button>
            </div>
        </div>

        <footer>
            
            <div class="logo">
                <span>CARCARÁ</span>
                <p>O Pássaro da notícia</p>
            </div>
        </footer>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cadastrarBtn = document.querySelector('.cadastrar-btn');
            const editarBtn = document.querySelector('.editar-btn');
            const visualizarBtn = document.querySelector('.visualizar-btn');
            const logoutBtn = document.querySelector('.logout-btn');

            // Redireciona para a página de cadastro de evento
            cadastrarBtn.addEventListener('click', function () {
                window.location.href = 'cadastro_eventos.php'; 
            });

            // Redireciona para a página de edição de eventos
            editarBtn.addEventListener('click', function () {
                window.location.href = 'listar_eventos.php'; 
            });

            // Redireciona para a página de eventos organizados por tipo
            visualizarBtn.addEventListener('click', function () {
                window.location.href = 'visualizar_eventos.php'; 
            });

            // Redireciona para a página de login (logout)
            logoutBtn.addEventListener('click', function () {
                window.location.href = 'login.php'; 
            });
        });
    </script>
</body>
</html>
