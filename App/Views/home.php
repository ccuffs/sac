<?php
use App\Helpers\UtilsHelper;
?>

<section class="intro" id="intro">
  <div class="intro__content">
    <div class="container">
      <h1 class="title intro__big-title" scroll-sensitive="animate-top-down">SEMANA ACÂDEMICA VII</h1>
      <p class="title" scroll-sensitive="animate-bottom-up">Ciência da Computação - UFFS</p>
      <p class="title title--small" scroll-sensitive="animate-bottom-up">Universidade Federal da Fronteira Sul - Novembro/2019</p>
    </div>
  </div>
</section>

<section class="about section" id="about">
  <div class="container">
    <div class="row justify-content-between flex-md-row-reverse">
      <div class="col-12 col-md-6 col-lg-5">
        <div class="about-item--redirect animate-right-left" scroll-sensitive="animate-left-right">
          <div class="ticket-wrapper d-flex flex-column">
            <div class="ticket-wrapper__title" scroll-sensitive="animate-left-right">
              <img src="<?= UtilsHelper::base_url("/img/icon-ticket.png") ?>" alt="Tickey">
              <h2 class="about__title">Inscreva-se</h2>
            </div>
            <div class="ticket-wrapper__buttons "scroll-sensitive="animate-right-left-3">
              <a href="<?= UtilsHelper::base_url("/login") ?>" class="btn btn--secondary">Estudante UFFS</a>
              <!-- <button class="btn btn--primary">Visitante</button> -->
            </div>
          </div>
        </div>
      </div>  
      <div class="col-12 col-md-6" scroll-sensitive="animate-left-right">
        <div class="about-item" scroll-sensitive="animate-right-left">
          <h2 class="about__title title">O que é SACC?</h2>
          <p>A semana acadêmica do curso de Ciência da computação é um momento de troca de conhecimentos proporcionado
          por docentes e discentes, no qual há uma semana de palestras e minicursos, relacionados à tecnologia.</p>
        </div>
        <div class="about-item" scroll-sensitive="animate-right-left">
          <h3 class="about-item__title title">Por quê ir?</h3>
          <p>A SACC busca oferecer, aos alunos e ao público em geral, a oportunidade de conviver e interagir com
            diversas áreas da computação, por meio de palestras, mesas-redondas e workshops é também uma
            oportunidade
            de alunos apresentarem pesquisas,interagirem e compartilharem seus conhecimentos com outras pessoas.</p>
          </div>
          <div class="about-item" scroll-sensitive="animate-right-left-3">
            <h3 class="about-item__title title">Para quem?</h3>
            <p> O evento é aberto para todos os interessados por tecnologia.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    
<section class="speakers section" id="speakers">
  <div class="container">
    <h2 class="speakers__title title" scroll-sensitive="animate-top-down">Palestrantes</h2>
    <div class="spearkers__list">
      <div class="speaker-card card" scroll-sensitive="animate-left-right">
        <div class="card__body">
          <div class="row align-items-center">
            <div class="col-12 col-md-5 col-lg-4">
              <div class="card__icon card__figure">
                <img width="100%"
                  src="https://media.gq.com/photos/563d215a6ff00fb522b05b01/master/pass/RIP-charlie-brown.jpg">
              </div>
            </div>
            <div class="col">
              <h3 class="speaker-card__title">Charlie Brown</h3>
              <p class="speaker-card__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
              <div class="speaker-card__description">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam a velit accumsan, condimentum
                  libero eu, vestibulum tellus. Sed nulla leo, varius a fringilla in, fringilla id arcu. In hac
                  habitasse platea dictumst. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="speaker-card card" scroll-sensitive="animate-right-left">
        <div class="card__body">
          <div class="row align-items-center">
            <div class="col-12 col-md-5 col-lg-4">
              <div class="card__icon card__figure">
                <img width="100%"
                  src="https://media.gq.com/photos/563d215a6ff00fb522b05b01/master/pass/RIP-charlie-brown.jpg">
              </div>
            </div>
            <div class="col">
              <h3 class="speaker-card__title">Charlie Brown</h3>
              <p class="speaker-card__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
              <div class="speaker-card__description">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam a velit accumsan, condimentum
                  libero eu, vestibulum tellus. Sed nulla leo, varius a fringilla in, fringilla id arcu. In hac
                  habitasse platea dictumst. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="speaker-card card" scroll-sensitive="animate-left-right">
      <div class="card__body">
        <div class="row align-items-center">
          <div class="col-12 col-md-5 col-lg-4">
            <div class="card__icon card__figure">
              <img width="100%"
                src="https://media.gq.com/photos/563d215a6ff00fb522b05b01/master/pass/RIP-charlie-brown.jpg">
            </div>
          </div>
          <div class="col">
            <h3 class="speaker-card__title">Charlie Brown</h3>
            <p class="speaker-card__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
            <div class="speaker-card__description">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam a velit accumsan, condimentum libero
                eu, vestibulum tellus. Sed nulla leo, varius a fringilla in, fringilla id arcu. In hac habitasse
                platea dictumst. </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="programming section" id="programming">
  <div class="container">
    <h2 class="programming__title title" scroll-sensitive="animate-top-down">Programação</h2>

    <div class="programming-item">
      <div class="row">
        <div class="col-12 col-lg-6">
          <div class="programming-item__day" scroll-sensitive="animate-left-right">Segunda, 07 de Outubro</div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="">
            <div class="lecture" scroll-sensitive="animate-right-left">
              <div class="lecture__time">
                13:30<br>
                14:20
              </div>
              <div class="lecture__details">
                <span class="lecture__title">
                  Titulo Palestra/Evento
                </span><br>
                <span class="lecture__speaker">Nome Pastrante(UFFS-Chapecó)</span>
              </div>
            </div>
            <div class="lecture" scroll-sensitive="animate-right-left-2">
              <div class="lecture__time">
                13:30<br>
                14:20
              </div>
              <div class="lecture__details ">
                <span class="lecture__title">
                  Titulo Palestra/Evento
                </span><br>
                <span class="lecture__speaker">Nome Pastrante(UFFS-Chapecó)</span>
              </div>
            </div>
            <div class="lecture" scroll-sensitive="animate-right-left-3">
                <div class="lecture__time">
                  13:30<br>
                  14:20
                </div>
                <div class="lecture__details ">
                  <span class="lecture__title">
                    Titulo Palestra/Evento
                  </span><br>
                  <span class="lecture__speaker">Nome Pastrante(UFFS-Chapecó)</span>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="programming-item">
      <div class="row">
        <div class="col-12 col-lg-6">
          <div class="programming-item__day" scroll-sensitive="animate-left-right">Terça 08 de Outubro</div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="lecture" scroll-sensitive="animate-right-left">
            <div class="lecture__time">
              13:30<br>
              14:20
            </div>
            <div class="lecture__details ">
              <span class="lecture__title">
                Titulo Palestra/Evento
              </span><br>
              <span class="lecture__speaker">Nome Pastrante(UFFS-Chapecó)</span>
            </div>
          </div>
          <div class="lecture" scroll-sensitive="animate-right-left-2">
              <div class="lecture__time">
                13:30<br>
                14:20
              </div>
              <div class="lecture__details ">
                <span class="lecture__title">
                  Titulo Palestra/Evento
                </span><br>
                <span class="lecture__speaker">Nome Pastrante(UFFS-Chapecó)</span>
              </div>
          </div>
          <div class="lecture" scroll-sensitive="animate-right-left-3">
              <div class="lecture__time">
                13:30<br>
                14:20
              </div>
              <div class="lecture__details ">
                <span class="lecture__title">
                  Titulo Palestra/Evento
                </span><br>
                <span class="lecture__speaker">Nome Pastrante(UFFS-Chapecó)</span>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="programming-item">
      <div class="row">
        <div class="col-12 col-lg-6">
          <div class="programming-item__day" scroll-sensitive="animate-left-right">Quarta, 08 de Outubro</div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="lecture" scroll-sensitive="animate-right-left">
            <div class="lecture__time">
              13:30<br>
              14:20
            </div>
            <div class="lecture__details">
              <span class="lecture__title">
                Titulo Palestra/Evento
              </span><br>
              <span class="lecture__speaker">
                Nome Pastrante(UFFS-Chapecó)
              </span>
            </div>
          </div>
          <div class="lecture" scroll-sensitive="animate-right-left-2">
              <div class="lecture__time">
                13:30<br>
                14:20
              </div>
              <div class="lecture__details ">
                <span class="lecture__title">
                  Titulo Palestra/Evento
                </span><br>
                <span class="lecture__speaker">Nome Pastrante(UFFS-Chapecó)</span>
              </div>
          </div>
          <div class="lecture" scroll-sensitive="animate-right-left-3">
            <div class="lecture__time">
              13:30<br>
              14:20
            </div>
            <div class="lecture__details">
              <span class="lecture__title">
                Titulo Palestra/Evento
              </span><br>
              <span class="lecture__speaker">Nome Pastrante(UFFS-Chapecó)</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>