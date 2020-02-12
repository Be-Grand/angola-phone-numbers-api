<!DOCTYPE html>
<html lang="pt_AO">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>NUS EVENTUS – Dedicação total a você</title>
		<meta name="description" content="{{$configs->description}}">
		<meta name="keywords" content="{{$configs->keywords}}">
    <link  rel="icon" type="image/x-icon" href="/assets/images/favicon.png">
    <meta   property="og:title" content="NUS VENTUS – Dedicação total a você">
    <meta   property="og:description" content="{{$configs->description}}">
    <meta   property="og:url" content="{{url('')}}">
    <meta  property="og:image"  content="{{$configs->image?'/storage/configs/'.$configs->image:''}}">
    <meta   property="og:image:secure_url" content="{{$configs->image?'/storage/configs/'.$configs->image:''}}">
    <meta  data-hid="twitter:title" name="twitter:title" content="NUS VENTUS – Dedicação total a você">
    <meta  data-hid="twitter:description" name="twitter:description" content="{{$configs->description}}">
    <meta  data-hid="twitter:image" name="twitter:image" content="{{$configs->image?'/storage/configs/'.$configs->image:''}}">
    <meta  name="theme-color" content="#52D18D"><meta  name="msapplication-navbutton-color" content="#52D18D">
    <meta  name="apple-mobile-web-app-capable" content="yes">
    <meta  name="apple-mobile-web-app-status-bar-style" content="#52D18D">
    <meta  property="keywords" content="Notícias">
    <meta  property="og:locale" content="pt_AO">
    <meta  property="og:type" content="website">
    <meta  property="og:site_name" content="NUS VENTUS">
    <meta  property="article:publisher" content="{{$configs->facebook_url}}">
    <meta  name="twitter:creator" content="@nuseventus">
    <meta  name="twitter:site" content="@nuseventus">
    <meta  name="twitter:card" content="summary_large_image">
    <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600|Montserrat:200,300,400" rel="stylesheet">

	  <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="assets/fonts/ionicons/css/ionicons.min.css">

    <link rel="stylesheet" href="assets/fonts/fontawesome/css/font-awesome.min.css">


    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/slick-theme.css">

    <link rel="stylesheet" href="assets/css/helpers.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/landing-2.css">
    <style>
            .img-carousel {
            height: 650px;
            width: 100%;
            object-fit: cover;
        }
        @media (max-width: 576px){
            .img-carousel {
                height: 250px;
                width: 100%;
                object-fit: cover;
            }
        }
        </style>
  </head>
  
  <head>



	<body data-spy="scroll" data-target="#pb-navbar" data-offset="200">
    <div class="fb-customerchat"
      page_id="819900384724130"
      logged_in_greeting="Olá, como podemos ajuda-lo?"
      logged_out_greeting="Até breve!... esperamos por você."
      minimized="false">
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark pb_navbar pb_scrolled-light" id="pb-navbar">
      <div class="container">
        <a class="navbar-brand" href="/">
        <img
            src="/assets/images/logo.png"
            alt="Logotipo Nus Eventus"
            style="width: 180px;"
           
          />
        </a>
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#probootstrap-navbar" aria-controls="probootstrap-navbar" aria-expanded="false" aria-label="Toggle navigation">
          <span><i class="ion-navicon"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="probootstrap-navbar">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="#section-home">Início</a></li>
            <li class="nav-item"><a class="nav-link" href="#section-features">Serviços</a></li>
            <li class="nav-item"><a class="nav-link" href="#section-reviews">Testemunhos</a></li>
            <li class="nav-item"><a class="nav-link" href="#section-faq">Perguntas frequentes</a></li>
            <li class="nav-item cta-btn ml-xl-2 ml-lg-2 ml-md-0 ml-sm-0 ml-0 mb-3"><a class="nav-link smoothscroll" href="tel:{{$configs->phone}}"><span class="pb_rounded-4 px-4">Ligar</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- END nav -->



    <section class="pb_cover_v3 overflow-hidden cover-bg-indigo cover-bg-opacity text-left pb_gradient_v1 pb_slant-light" id="section-home">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6">
            <h2 class="heading mb-3" style="font-size: 56px;">Dedicação total a si</h2>
            <div class="sub-heading">
              <p class="mb-4">Poupe o seu tempo, dinheiro e esforço, deixe a tua imaginação tornar-se realidade, escolhe os nossos serviços para a actidade da sua vida.</p>
              <p class="mb-5"><a class="btn btn-success btn-lg pb_btn-pill smoothscroll" href="tel:{{$configs->phone}}"><span class="pb_font-14 text-uppercase pb_letter-spacing-1">Ligue já</span></a></p>
            </div>
          </div>
          <div class="col-md-1">
          </div>
          <div class="col-md-5 relative align-self-center">

            <form method="post" action="/contact" class="bg-white rounded pb_form_v1">
            {{ csrf_field() }}
            @if(session('message'))
            <div class="alert alert-success">
                <b>{{session('message')}}</b>
            </div>
            @endif
              <h2 class="mb-4 mt-0 text-center">Entrar em contacto</h2>
              <div class="form-group">
                <input type="text" required name="name" class="form-control pb_height-50 reverse" placeholder="Nome completo">
                {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
              </div>
              <div class="form-group">
                <input type="text"  name="email" class="form-control pb_height-50 reverse" placeholder="E-mail">
                {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
              </div>
              <div class="form-group">
                <input type="text" required name="phone" class="form-control pb_height-50 reverse" placeholder="Nº de telefone">
                {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
              </div>
              <div class="form-group">
                <div class="pb_select-wrap">
                  <select required class="form-control pb_height-50 reverse" name="topic">
                    <option value="" selected>Assunto</option>
                    <option value="Obtenção dos serviços">Obtenção dos serviços</option>
                    <option value="Parceria">Parceria</option>
                    <option value="Outros">Outros</option>
                  </select>
                </div>
                {!! $errors->first('topic', '<p class="text-danger">:message</p>') !!}
              </div>
              <div class="form-group">
                <textarea required class="form-control pb_height-50 reverse" name="body" placeholder="Descrição" rows="3"></textarea>
                {!! $errors->first('body', '<p class="text-danger">:message</p>') !!}
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary btn-lg btn-block pb_btn-pill  btn-shadow-blue" value="Enviar">
              </div>
    
            </form>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="pb_section bg-light  pb_pb-250" id="section-features">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-6 text-center mb-5">
            <h5 class="text-uppercase pb_font-15 mb-2 pb_color-dark-opacity-3 pb_letter-spacing-2"><strong>Serviços</strong></h5>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md- col-sm-6">
            <div class="media d-block pb_feature-v1 text-center">
              <div class="pb_icon"><i class="ion-android-volume-up pb_icon-gradient"></i></div>
              <div class="media-body">
                <h5 class="mt-0 mb-3 heading">Música</h5>
                <p class="text-sans-serif">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md- col-sm-6">
            <div class="media d-block pb_feature-v1 text-center">
              <div class="pb_icon"><i class="ion-android-bulb pb_icon-gradient"></i></div>
              <div class="media-body">
                <h5 class="mt-0 mb-3 heading">Iluminação</h5>
                <p class="text-sans-serif">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md- col-sm-6">
            <div class="media d-block pb_feature-v1 text-center">
              <div class="pb_icon"><i class="ion-android-camera pb_icon-gradient"></i></div>
              <div class="media-body">
                <h5 class="mt-0 mb-3 heading">Imagem</h5>
                <p class="text-sans-serif">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- END section -->
    
    <section>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    @foreach($galleries as $gallery)
      <li data-target="#carouselExampleIndicators" data-slide-to="{{$loop->index}}" class="{{$loop->first? 'active':''}}"></li>
    @endforeach

  </ol>
  <div class="carousel-inner" role="listbox">
    @foreach($galleries as $gallery)
      <div class="carousel-item {{$loop->first? 'active':''}}"> 
          <img class="img-carousel" src="{{'/storage/galleries/'.$gallery->image}}" alt="Imagem {{$gallery->id}} da galeria">
      </div>
    @endforeach
  
  </div>
</div>
    </section>
    <!-- END section -->



    <section class="pb_section pb_slant-light pb_pb-220" id="section-reviews">
      <div class="container">
        <div class="row justify-content-center mb-1">
          <div class="col-md-6 text-center mb-5">
            <h5 class="text-uppercase pb_font-15 mb-2 pb_color-dark-opacity-3 pb_letter-spacing-2"><strong>Testemunhos</strong></h5>
            <h2>As pessoas gostam e recomendam a Nus Eventus.</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md">
            <div class="pb_slide_testimonial_sync_v1">
              <div class="pb_slider_content js-pb_slider_content2">
                @foreach($reviews as $review)
                  <div>
                    <div class="media d-block text-center testimonial_v1 pb_quote_v2">
                      <div class="media-body">
                        <div class="quote">&ldquo;</div>
                        <blockquote class="mb-5">{{$review->review}}</blockquote>
                        <p>
                          @for ($i = 0; $i < $review->stars; $i++)
                            <i class="ion-ios-star text-warning"></i>
                          @endfor
                          @for ($i = 0; $i < 5-$review->stars; $i++)
                            <i class="ion-ios-star-outline text-warning"></i>
                          @endfor
                        </p>
                        <h3 class="heading">{{$review->name}}</h3>
                        <span class="subheading">{{'@'.$review->user_name}}</span>

                      </div>
                    </div>
                  </div>
                @endforeach
              </div>

              <div class="row">
                <div class="col-md-6 mx-auto">
                  <div class="pb_slider_nav js-pb_slider_nav2">
                    @foreach($reviews as $review)
                    <div class="author">
                      <img class="img-fluid rounded-circle" src="{{$review->image? '/storage/reviews/'.$review->image :'/assets/images/noPerson.png'}}" style="height: 64px; width: 64px; object-fit: cover;" alt="Imagem de {{$review->name}}">
                    </div>
                    @endforeach
                    
                  </div>
                </div>
              </div>

            </div>
            <!-- END sync_v1 -->
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->



    <section class="pb_section pb_slant-white" id="section-faq">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-6 text-center mb-5">
            <h5 class="text-uppercase pb_font-15 mb-2 pb_color-dark-opacity-3 pb_letter-spacing-2"><strong>FAQ</strong></h5>
            <h2>Perguntas Frequentes</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md">
            <div id="pb_faq" class="pb_accordion" data-children=".item">
              @foreach($faqs as $faq)
                <div class="item">
                  <a data-toggle="collapse" data-parent="#pb_faq" href="{{'#pb_faq'.$faq->id}}" aria-expanded="{{$faq->id==1?'true':'false'}}" aria-controls="{{'pb_faq'.$faq->id}}" class="pb_font-22 py-4">{{$faq->question}}</a>
                  <div id="{{'pb_faq'.$faq->id}}" class="collapse {{$faq->id==1?'show':''}}" role="tabpanel">
                    <div class="py-3">
                      <p>{{$faq->answer}}</p>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

   

    <footer class="pb_footer bg-light" role="contentinfo" style="padding-top: 170px;">
      <div class="container">
        <div class="row text-center">
          <div class="col">
            <ul class="list-inline">
              <li class="list-inline-item"><a href="{{$configs->facebook_url}}" class="p-2"><i class="fa fa-facebook"></i></a></li>
              <li class="list-inline-item"><a  href="{{$configs->instagram_url}}"class="p-2"><i class="fa fa-instagram"></i></a></li>
              <li class="list-inline-item"><a  href="{{$configs->twitter_url}}"class="p-2"><i class="fa fa-twitter"></i></a></li>
              <li class="list-inline-item"><a  href="{{$configs->linkedin_url}}" class="p-2"><i class="fa fa-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col text-center">
            <p class="pb_font-14">&copy;  <?php echo date("Y");?>. Todos direitos reservados. <br>  <a href="/">Nus Eventus</a></p>
           
          </div>
        </div>
      </div>
    </footer>

    <!-- loader -->
    <div id="pb_loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#1d82ff"/></svg></div>



    <script src="assets/js/jquery.min.js"></script>

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/jquery.mb.YTPlayer.min.js"></script>

    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/jquery.easing.1.3.js"></script>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/messenger.js"></script>

	</body>
</html>
