<?php 
use App\Helpers\UtilsHelper;
?>

<div class="jumbotron">
    <div class="container">
        <h1>Eventos</h1>
        <p>Gerenciar eventos</p>
    </div>
</div>

<div class="container">
    <div>
        <a href="<?= UtilsHelper::base_url("/admin/evento") ?>" class="btn btn-default">Voltar</a>
        <a href="<?= UtilsHelper::base_url("/admin/evento/" . $event->id . "/edit") ?>" class="btn btn-primary">Editar</a>
        <a href="<?= UtilsHelper::base_url("/admin/evento/" . $event->id . "/delete") ?>" class="btn btn-warning">Remover</a>
    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading">
            Detalhes:
        </div>
        <div class="panel-body">
            <p><b>Título:</b> <?= $event->title ?></p>
            <p><b>Data:</b> <?= $event->day ?>/<?= $event->month ?></p>
            <p><b>Horário:</b> <?= $event->time ?></p>
            <p><b>Local:</b> <?= $event->place ?></p>
            <p><b>Preço:</b> R$<?= str_replace('.', ',', $event->price) ?></p>
            <p><b>Capacidade: </b> <?= $event->capacity ?></p>
            <p><b>Fantasma: </b> <?= $event->ghost ? "Sim" : "Não" ?></p>
            <p><b>Descrição:</b> <?= $event->description ?></p>
        </div>
    </div>
</div>