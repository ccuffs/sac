<?php 
use App\Helpers\UtilsHelper;
?>

<div class="jumbotron">
    <div class="container">
        <h1>Competições</h1>
        <p>Gerenciar competições</p>
    </div>
</div>

<div class="container">
    <div>
        <a href="<?= UtilsHelper::base_url("/admin/campeonato") ?>" class="btn btn-default">Voltar</a>
        <a href="<?= UtilsHelper::base_url("/admin/campeonato/" . $competition->id . "/edit") ?>" class="btn btn-primary">Editar</a>
        <a href="<?= UtilsHelper::base_url("/admin/campeonato/" . $competition->id . "/delete") ?>" class="btn btn-warning">Remover</a>
    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading">
            Detalhes:
        </div>
        <div class="panel-body">
            <p><b>Título:</b> <?= $competition->title ?></p>
            <p><b>Headline:</b> <?= $competition->headline ?></p>
            <p><b>Premiação: </b> <?= $competition->prizes ?></p>
            <p><b>Regras: </b> <?= $competition->rules ?></p>
            <p><b>Descrição:</b> <?= $competition->description ?></p>
        </div>
    </div>
</div>