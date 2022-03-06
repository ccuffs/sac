<?php 
use App\Helpers\UtilsHelper;
?>

<section class="intro" id="intro">
  <div class="intro__content">
    <div class="container">
      <h1 class="title intro__big-title" scroll-sensitive="animate-top-down">VIII SEMANA ACADÊMICA</h1>
      <p class="title" scroll-sensitive="animate-bottom-up">Ciência da Computação - UFFS</p>
      <p class="title title--small" scroll-sensitive="animate-bottom-up">Dia 16, 17 e 18 - Março/2022</p>
      <p class="title title--small" scroll-sensitive="animate-bottom-up">Universidade Federal da Fronteira Sul</p>
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
              <a href="<?= UtilsHelper::base_url("/inscricao/aluno") ?>" class="btn btn--secondary">Estudante UFFS</a>
              <a href="<?= UtilsHelper::base_url("/inscricao/visitante/cadastro") ?>" class="btn btn--primary">Visitante</a>
            </div>
          </div>
        </div>
      </div>  
      <div class="col-12 col-md-6" scroll-sensitive="animate-left-right">
        <div class="about-item" scroll-sensitive="animate-right-left">
          <h2 class="about__title title">O que é SACC?</h2>
          <p>A semana acadêmica do curso de Ciência da computação
          é um momento de troca de conhecimentos proporcionado por
          docentes e discentes, no qual há um conjunto de palestras,
          minicursos e <i>oficinas</i>, relacionados à tecnologia.</p>
        </div>
        <div class="about-item" scroll-sensitive="animate-right-left">
          <h3 class="about-item__title title">Por que participar?</h3>
          <p>
            A SACC busca oferecer aos alunos e ao público em geral
            a oportunidade de absorver e compartilhar conhecimento, 
            conviver e interagir com diversas áreas da computação,
            por meio de palestras, oficinas e minicursos.
            Ela é também uma oportunidade para os estudantes tornarem
            público seus esforços e resultados de suas pesquisas, além de movimentar 
            a rotina de estudantes e professores através de atividades diferenciadas, 
            proporcionando momentos de aprendizagem e, 
            ao mesmo tempo, de interação e integração da comunidade acadêmica.
          </p>

          </div>
          <div class="about-item" scroll-sensitive="animate-right-left-3">
            <h3 class="about-item__title title">Para quem?</h3>
            <p>
              O evento é aberto para todos os interessados por tecnologia
              e principalmente para aqueles que acreditam que o curso de ciência
              da computação vai muito além da sala de aula.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="schedule section" id="schedule">
    <div class="container">
       <h2 class="schedule__title title" scroll-sensitive="animate-top-down">Programação</h2>
      
        <?php foreach ($day_programming as $event_per_day): ?>
          <?php $event_head = reset($event_per_day) ?>
          <div class="schedule-item">
            <div class="row">
              <div class="col-12 col-lg-6">
                <div class="schedule-item__day" scroll-sensitive="animate-left-right"><?= UtilsHelper::weekDayToString($event_head->day, $event_head->month) .', '. (strlen($event_head->day) == 1 ? '0'.$event_head->day : $event_head->day) . ' de ' . UtilsHelper::monthToString($event_head->month)?></div>
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

                        <?php foreach ($event->getSpeakers() as $speaker): ?>
                        <span class="event__strong"> Palestrante: </span>
                        <a href="#palestrante/<?= $speaker->name ?>"> <?= $speaker->name ?> </a><br>
                        <?php endforeach; ?>

                        <span class="event__strong"> Horário: </span>
                        <span> <?= $event->time . ''?> </span><br>

                        <span class="event__strong"> Local: </span>
                        <span> <?= $event->place ?></span> <br>

                        <?php if ($event->price > 0): ?>
                        <span class="event__strong"> Custo: </span>
                        <span> <?= UtilsHelper::format_money_view($event->price) ?></span>
                        <?php endif; ?>

                      </div>
                    </div>
                  <?php endforeach;?>
              </div>

            </div>
        </div>
    <?php endforeach; ?>
</section>

<section class="speakers section" id="speakers">
  <div class="container">
    <h2 class="speakers__title title" scroll-sensitive="animate-top-down">Palestrantes</h2>
    <div class="spearkers__list">
      <?php foreach($speakers as $speaker): ?>
      <div class="speaker-card card" id="palestrante/<?= $speaker->name ?>" scroll-sensitive="animate-left-right">
        <div class="card__body">
          <div class="row align-items-center">
            <div class="col-12 col-md-4 col-lg-3">
              <div class="card__icon card__figure">
                <img width="100%"
                  src="<?= UtilsHelper::storage_url($speaker->img_path) ?>">
              </div>
            </div>
            <div class="col">
              <h3 class="speaker-card__title"><?= $speaker->name ?></h3>
              <!-- <p class="speaker-card__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p> -->
              <div class="speaker-card__description">
                <p><?= $speaker->description ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
  </div>
</section>


<section class="values section" id="values">
    <div class="container">
        <h2 class="values__title title" scroll-sensitive="animate-top-down">Valores</h2>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <p>Confira a tabela de preços da semana acadêmica!</p>
                <table class="table table--lg table--bordered">
                    <tr class="bg-primary-light">
                        <!--<th>Lote</th>-->
                        <th>Estudante UFFS</th>
                        <!--<th class="d-none d-sm-table-cell">Estudante UFFS</th>-->
                        <th class="d-none d-sm-table-cell">Visitante/Docente</th>
                    </tr>
                    <tr>
                        <!--<td><b>1º lote</b></td>-->
                        <td>R$ 10,00</td>
                        <!--<td class="d-none d-sm-table-cell" rowspan="3">R$ 15,00</td>-->
                        <td class="d-none d-sm-table-cell" rowspan="3">R$ 30,00</td>
                    </tr>
                    <!--<tr>
                        <td><b>2º lote</b></td>
                        <td>R$ 10,00</td>
                    </tr>
                    <tr>
                        <td><b>No dia</b></td>
                        <td>R$ 15,00</td>
                    </tr>-->
                </table>
                <!--<table class="d-table d-sm-none mt-4 table table--lg table--bordered">
                    <tr class="bg-primary-light">
                        <th>Estudante UFFS</th>
                    </tr>
                    <tr>
                        <td>R$ 15,00</td>
                    </tr>
                </table>
                <table class="d-table d-sm-none mt-4 table table--lg table--bordered">
                    <tr class="bg-primary-light">
                        <th>Visitante</th>
                    </tr>
                    <tr>
                        <td>R$ 40,00</td>
                    </tr>
                </table>-->
            </div>
        </div>
        <h3 class="values__subtitle title" scroll-sensitive="animate-top-down">Pagamento</h2>
        <div class="row">
            <div class="offset-lg-3 col-lg-6">
                <p>O pagamento pode ser feito para algum membro do CA na sala 307B nos intervalos das aulas, ou via pix para a chave cacomputacaouffs@gmail.com. <br>
                 Qualquer dúvida envie um e-mail para <a href="mailto:cacomputacaouffs@gmail.com">cacomputacaouffs@gmail.com</a> ou entre em contato pelas redes sociais:</p>
                <p><b>Instagram:</b> <a href="https://www.instagram.com/caccuffs/" target="_blank">caccuffs</a></p>
            </div>
        </div>
        <h3 class="values__subtitle title" scroll-sensitive="animate-top-down">Patrocínios</h2>
        <div class="row">
          <div class="offset-lg-3 col-lg-6" class="patrocinio">
                <h4>Patrocínio Ouro</h4>
                <img src="<?= UtilsHelper::base_url("/img/ouro.png") ?>" width="350px">
                <h5>Patrocínio Prata</h5>
                <img src="<?= UtilsHelper::base_url("/img/prata.png") ?>" width="200px">
                
          </div>
        </div>
    </div>
</section>