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
        <a href="<?= UtilsHelper::base_url("/admin/evento/create") ?>" class="btn btn-success">Adicionar</a>
    </div>
    <br>
    <table class="table table-striped">
        <tr>
            <th>Nome:</th>
            <th>Dia:</th>
            <th></th>
        </tr>
        <?php foreach($events as $event): ?>
        <tr>
            <td><?= $event->title ?></td>
            <td><?= $event->day ?>/<?= $event->month ?></td>
            <td width="50">
                <a href="<?= UtilsHelper::base_url("/admin/evento/" . $event->id) ?>" class="btn btn-primary">Visualizar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>