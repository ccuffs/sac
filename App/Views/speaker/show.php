<?php 
use App\Helpers\UtilsHelper;
?>

<div class="jumbotron">
    <div class="container">
        <h1>Palestrantes</h1>
        <p>Gerenciar palestrantes</p>
    </div>
</div>

<div class="container">
    <div>
        <a href="<?= UtilsHelper::base_url("/admin/palestrantes") ?>" class="btn btn-default">Voltar</a>
        <a href="<?= UtilsHelper::base_url("/admin/palestrantes/" . $speaker->id . "/edit") ?>" class="btn btn-primary">Editar</a>
        <a href="<?= UtilsHelper::base_url("/admin/palestrantes/" . $speaker->id . "/delete") ?>" class="btn btn-warning">Remover</a>
    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading">
            Detalhes:
        </div>
        <div class="panel-body">
            <p><b>Nome:</b> <?= $speaker->name ?></p>
            <p><b>Descrição:</b> <?= $speaker->description ?></p>
            <p><b>Imagem:</b> <?= $speaker->img_path ?></p>
        </div>
    </div>
</div>