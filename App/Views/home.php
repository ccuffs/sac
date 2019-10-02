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
    <div class="row justify-content-between">
      <div class="col-12 col-md-5" scroll-sensitive="animate-left-right">
        <h2 class="about__title title">O que é SACC?</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam a velit accumsan, condimentum libero eu,
          vestibulum tellus. Sed nulla leo, varius a fringilla in, fringilla id arcu. In hac habitasse platea
          dictumst. Vivamus nec augue vitae turpis varius ultricies in at mauris. Mauris in elementum enim. Fusce eget
          faucibus dui. Nunc quis semper ex.</p>
      </div>
      <div class="col-12 col-md-6">
        <div class="about-item" scroll-sensitive="animate-right-left">
          <h3 class="about-item__title title">Por quê ir?</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam a velit accumsan, condimentum libero eu,
            vestibulum tellus. Sed nulla leo, varius a fringilla in, fringilla id arcu. In hac habitasse platea
            dictumst. Mauris in elementum enim. Nunc quis semper ex.</p>
        </div>
        <div class="about-item" scroll-sensitive="animate-right-left-2">
          <h3 class="about-item__title title">Objetivo</h3>
          <p>Lorem ipsum dolor sit amet, elit. Aliquam a velit accumsan, condimentum libero eu, vestibulum tellus. Sed
            nulla leo, varius a fringilla in, fringilla id arcu. In hac habitasse platea dictumst. Vitae turpis varius
            ultricies in at mauris. Fusce eget faucibus dui. Nunc quis semper ex.</p>
        </div>
        <div class="about-item" scroll-sensitive="animate-right-left-3">
          <h3 class="about-item__title title">Para quem?</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam a velit accumsan, vestibulum tellus.
            Vivamus rarius ultricies in at mauris. Mauris in elementum enim. Fusce eget faucibus dui. Nunc quis semper
            ex.</p>
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
  </section>

  <section class="programming section" id="programming">
    <div class="container">
      <h2 class="programming__title title" scroll-sensitive="animate-top-down">Programação</h2>
      
      <?php foreach ($data['events'] as $event_per_day): ?>
          <?php $event_head = reset($event_per_day) ?>
          <div class="programming-item">
            <div class="row">
              <div class="col-12 col-lg-6">
                <div class="programming-item__day" scroll-sensitive="animate-left-right"><?= UtilsHelper::weekDayToString($event_head->day, $event_head->month) .', '. (strlen($event_head->day) == 1 ? '0'.$event_head->day : $event_head->day) . ' de ' . UtilsHelper::monthToString($event_head->month)?></div>
              </div>

              <div class="col-12 col-lg-6">
                  <?php foreach ($event_per_day as $event): ?>
                    
                    <div class="lecture" scroll-sensitive="animate-right-left">
                      <div class="lecture__time">
                      </div>
                      <div class="lecture__details">
                        <span class="lecture__title">
                          <?= $event->title ?>
                        </span><br>
                        <span> <?= $event->description?> </span> <br>

                        <span class="event__strong"> Palestrante: </span>
                        <span> <?= isset($event->speaker) ? $event->speaker : 'Fausto Silva' ?> </span><br>

                        <span class="event__strong"> Início: </span>
                        <span> <?= $event->time . ' hrs'?> </span><br>

                        <span class="event__strong"> Local: </span>
                        <span> <?= $event->place ?></span> <br>

                        <span class="event__strong"> Custo: </span>
                        <span> <?= $event->price > 0 ? UtilsHelper::format_money_view($event->price) : 'Gratuito'?></span>

                      </div>
                    </div>
                  <?php endforeach;?>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
</section>
