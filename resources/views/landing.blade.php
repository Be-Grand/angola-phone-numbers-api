<!DOCTYPE html>
<html lang="pt_AO">

<head>
  <title>Angola Phone Numbers Api - APNA</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="APNA é uma API angolana criada para ajudar os
  desenvolvedores conseguirem informações como de qual operadora, a quem pertence e qual número de
  bilhete um número de telefone está associado para as validações no momento de cadastro.">
  <meta name="keywords" content="Angola, Número de Telefone, API, Validação, Informações, Desenvolvimento">
  <link rel="icon" type="image/x-icon" href="/images/favicon.png">
  <meta property="og:title" content="Angola Phone Numbers Api - APNA">
  <meta property="og:description" content="APNA é uma API angolana criada para ajudar os
  desenvolvedores conseguirem informações como de qual operadora, a quem pertence e qual número de
  bilhete um número de telefone está associado para as validações no momento de cadastro.">
  <meta property="og:url" content="{{url('')}}">
  <meta property="og:image" content="/images/background.jpg">
  <meta property="og:image:secure_url" content="/images/background.jpg">
  <meta data-hid="twitter:title" name="twitter:title" content="Angola Phone Numbers Api - APNA">
  <meta data-hid="twitter:description" name="twitter:description" content="APNA é uma API angolana criada para ajudar os
  desenvolvedores conseguirem informações como de qual operadora, a quem pertence e qual número de
  bilhete um número de telefone está associado para as validações no momento de cadastro.">
  <meta data-hid="twitter:image" name="twitter:image"
    content="/images/background.jpg">
  <meta name="theme-color" content="#08c">
  <meta name="msapplication-navbutton-color" content="#08c">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="#08c">
  <meta property="keywords" content="Notícias">
  <meta property="og:locale" content="pt_AO">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Angola Phone Numbers Api - APNA">
  <meta property="article:publisher" content="https://www.facebook.com/Be-Grand-Technology-111736843734225/">
  <meta name="twitter:creator" content="@begrand">
  <meta name="twitter:site" content="@begrand">
  <meta name="twitter:card" content="summary_large_image">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>


    <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">

      <div class="container-fluid">
        <div class="d-flex align-items-center">
          <div class="site-logo mr-auto w-25"><a href="index.html">APNA</a></div>

          <div class="mx-auto text-center">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mx-auto d-none d-lg-block  m-0 p-0">
                <li><a href="#home-section" class="nav-link">Inicio</a></li>
                <li><a href="#courses-section" class="nav-link">Sobre</a></li>
                <li><a href="#programs-section" class="nav-link">Team</a></li>
                <li><a href="https://github.com/Be-Grand/angola-phone-numbers-api" class="nav-link">GitHub</a></li>
              </ul>
            </nav>
          </div>

          <div class="ml-auto w-25">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu site-menu-dark js-clone-nav mr-auto d-none d-lg-block m-0 p-0">
                <li class="cta"><a href="#contact-section" class="nav-link"><span>Fazer doação</span></a></li>
              </ul>
            </nav>
            <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right"><span
                class="icon-menu h3"></span></a>
          </div>
        </div>
      </div>

    </header>

    <div class="intro-section" id="home-section">

      <div class="slide-1" style="background-image: url('images/background.jpg');" data-stellar-background-ratio="0.5">
        <div class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
          <div class="row align-items-center">
            <div class="col-12">
              <div class="row align-items-center">
                <div class="col-lg-6">
                  <h1 data-aos="fade-up" data-aos-delay="100">Angola Phone Numbers Api</h1>
                  <p class="mb-4" data-aos="fade-up" data-aos-delay="200">É uma API angolana criada para ajudar os
                    desenvolvedores conseguirem informações como de qual operadora, a quem pertence e qual número de
                    bilhete um número de telefone está associado para as validações no momento de cadastro.</p>
                  <p data-aos="fade-up" data-aos-delay="300"><a
                      href="https://github.com/Be-Grand/angola-phone-numbers-api"
                      class="btn btn-primary py-3 px-5 btn-pill">Documentação</a></p>

                </div>
                <div class="col-lg-6 ml-auto" data-aos="fade-up" data-aos-delay="500">
                  <form method="post" action="/create"  class="form-box">
                    {{ csrf_field() }}
                    @if(session('message'))
                    <div class="alert alert-success">
                        <b>{{session('message')}}</b>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <b>{{session('error')}}</b>
                    </div>
                    @endif
                    <h3 class="h4 text-black mb-4">Cadastrar Telefone
                    </h3>
                    <div class="form-group">
                      <input type="text" required name="name" class="form-control" placeholder="Nome Completo">
                      {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                    </div>
                    <div class="row">
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <input type="date" required name="birth_date" class="form-control"
                            placeholder="Data de nascimento">
                            {!! $errors->first('birth_date', '<p class="text-danger">:message</p>') !!}
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <select required class="form-control" name="gender">
                          <option selected>Genéro</option>
                            <option value="0">Masculino</option>
                            <option value="1">Femenino</option>
                            <option value="2">Empresa / Organização</option>
                          </select>
                          {!! $errors->first('gender', '<p class="text-danger">:message</p>') !!}
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="text" required name="address" class="form-control" placeholder="Endereço">
                    </div>
                    <div class="row">
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <select required class="form-control" name="doc_type">
                          <option selected>Tipo de documento</option>
                            <option value="passport">Passaporte</option>
                            <option value="nif">Cartão de contribuente</option>
                            <option value="bi">Bilhete de identidade</option>
                            <option value="residence_card">Cartão de residente</option>
                          </select>
                          {!! $errors->first('doc_type', '<p class="text-danger">:message</p>') !!}
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <input type="text" name="doc_no" class="form-control" placeholder="Número do documento">
                          {!! $errors->first('doc_no', '<p class="text-danger">:message</p>') !!}
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="email" name="email" class="form-control" placeholder="E-mail">
                      {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                    </div>

                    <div class="row">
                      <div class="col-12 col-md-6">

                        <div class="form-group">
                          <select required class="form-control" name="operator_id">
                            <option selected>Operadora</option>
                            @foreach($operators as $operator)
                              <option value="{{$operator->id}}">{{$operator->name}}</option>
                            @endforeach
                          </select>
                          {!! $errors->first('operator_id', '<p class="text-danger">:message</p>') !!}
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="form-group mb-4">
                          <input type="text" name="number" class="form-control" placeholder="Númmero de telefone">
                          {!! $errors->first('number', '<p class="text-danger">:message</p>') !!}
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <input type="submit" class="btn btn-primary btn-pill" value="Cadastrar">
                    </div>
                  </form>

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>


    <div class="site-section courses-title" id="courses-section">
      <div class="container">
        <div class="row mb-5 justify-content-center">
          <div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="">
            <h2 class="section-title">Sobre</h2>
            <p class="text-white">APNA que significa Angola Phone Number API, é uma API Angolana criada por Be Grand,
              uma
              equipa de desenvolvimento de softwares, cujo a finalidade é ajudar o processo de validação de cadastros
              nos outros sistemas, fornecendo informações como nome completo e número de documento de identificação a
              partir
              do processo de cadastro.
            </p>
          </div>
        </div>
      </div>
    </div>



    <div class="site-section" id="programs-section">
      <div class="container">
        <div class="row mb-5 justify-content-center">
          <div class="col-lg-7 text-center" data-aos="fade-up" data-aos-delay="">
            <h2 class="section-title">Team</h2>
            <p>O team Be Grand está composto por programadores front-end, back-end e UI e UX designers na qual prestam
              serviços de desenvolvimento web e mobile em todo mundo.
            </p>
          </div>
        </div>
      </div>
    </div>

    <footer class="site-section bg-light" id="contact-section">
      <div class="container">

        <div class="row justify-content-center">
          <div class="col-md-12 text-center">
            <h2 class="section-title ">Fazer doação</h2>
            <p class="mb-5">Pode fazer doação fazendo uma transferência bancária ou no Paypal.</p>
            <h5 class="text-center">Titular das contas: <b>Ravelino de Castro</b></h5>
            <hr>
            <div class="row mb-5">
              <div class="col-12 col-md-4">
                <p>País: <b>Angola</b></p>
                <p>Banco: <b>Millenium Atlantico</b></p>
                <p>IBAN: <b>AO06 0040 0000 1812 7588 1016 5</b></p>
                <p>Nº da conta: <b>1181275810001</b></p>
                <p>SWIFT: <b>BAIPAPLU</b></p>
              </div>
              <div class="col-12 col-md-4">
                <p>País: <b>Portugal</b></p>
                <p>Banco: <b>Atlantico Europa</b></p>
                <p>IBAN: <b>PT50 0189 0002 5934 7512 0017 5</b></p>
                <p>Nº da conta: <b>259347510001</b></p>
                <p>SWIFT: <b>BAPAPTPL</b></p>
              </div>
              <div class="col-12 col-md-4">
                <form action="/donate" method="post" data-aos="fade">
                  {{ csrf_field() }}
                  @if(session('message_paypal'))
                  <div class="alert alert-success">
                      <b>{{session('message_paypal')}}</b>
                  </div>
                  @endif
                  @if(session('error_paypal'))
                  <div class="alert alert-danger">
                      <b>{{session('error_paypal')}}</b>
                  </div>
                  @endif
                <p><b>Via PayPal</b></p>
                  <div class="form-group d-flex justify-content-center">
                    <div class="col-md-8">
                      <input type="number" required name="amount" class="form-control" placeholder="Quantia para doar">
                    </div>
                  </div>
                  <div class="form-group d-flex justify-content-center">
                    <div class="col-md-8">
                      <input type="submit" class="btn btn-primary py-3 px-5 btn-block btn-pill" value="Doar">
                      {!! $errors->first('amount', '<p class="text-danger">:message</p>') !!}
                    </div>
                  </div>

                </form>
              </div>
            </div>

          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <div class="pt-5">
              <p>
                &copy;
                <script>document.write(new Date().getFullYear());</script> Todos direitos reservados por <a
                  href="https://github.com/be-grand" target="_blank">Be Grand Technology</a>
              </p>
            </div>
          </div>

        </div>
      </div>
    </footer>




  </div> <!-- .site-wrap -->

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/jquery.sticky.js"></script>


  <script src="js/main.js"></script>

</body>

</html>