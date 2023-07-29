<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

        <link rel="stylesheet" href="/style/style.css">
        <script src="/js/main.js"></script>
    </head>

    <body>

      <header>
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="collapse navbar-collapse" id="navbar">
            <a href="/" class="navbar-brand">
              <img src="/img/hdcevents_logo.svg" alt="Logo" >
            </a>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a href="/" class="nav-link">Eventos</a>
              </li>
              <li class="nav-item">
                <a href="/events/create" class="nav-link">Criar Evento</a>
              </li>

              @auth
                <li class="nav-item">
                  <a href="/dashboard" class="nav-link">Meus Eventos</a>
                </li>
                <li class="nav-item">
                  <form action="/logout" method="POST">
                  @csrf
                  <a href="/logout" 
                  class="nav-link"
                  onclick="event.preventDefault(); // O JavaScript irá tratar o clique e enviar a solicitação do formulário.
                  this.closest('form').submit(); // JavaScript localiza o elemento 'form' mais próximo ao link em que o usuário clicou eo submete">
                  Sair
                  </a>
                  <!--  Quando o usuário clica no link "Sair", o JavaScript executa o código event.preventDefault(); para evitar o redirecionamento imediato e, em vez disso, envia a solicitação POST para a rota "/logout"  -->
                  </form>
                </li>
              @endauth

              @guest
                <li class="nav-item">
                  <a href="/login" class="nav-link">Entrar</a>
                </li>
                <li class="nav-item">
                  <a href="/register" class="nav-link">Cadastrar</a>
                </li>
              @endguest

            </ul>
          </div>
        </nav>
      </header>

      <div class="container-fluid">
        <div class="row">
          @if(session('msg'))
            <p class="msg">{{session('msg')}}</p>
          @endif
        </div>
      </div>


      @yield('content')

      <footer>

        <p>Pietro &copy;2023</p>
      </footer>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>
