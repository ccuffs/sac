<?php 
use App\Models\User;
use App\Models\Event;
use App\Helpers\View;
use App\Helpers\UtilsHelper;  
?>


<div class="jumbotron">
    <div class="container">
        <h1> Palestrantes </h1>
        <p>Adicionar, remover ou alterar informações dos palestrantes. </p>
    </div>
</div>

<div class="container">
    <div>
        <a href = "<?= UtilsHelper::base_url("/admin/palestrantes/create") ?>" class="btn btn-success">Adicionar</a>
    </div>
    <br>

    <table class="table table-striped">

        <tr>
            <th> Nome </th>
            <th> Descrição </th>
            <th> Palestra </th>
        </tr>

        <?php foreach($speakers as $speaker): ?>
            <tr>
                <td> <?= $speaker->name ?>  </td>
                <td> <?= $speaker->description ?> </td>
                <td>
                    <?foreach($events as $event): ?>
                            <?php if(isset($event->fk_speaker) && $speaker->id == $event->fk_speaker): ?>
                                <span>
                                    <?= $event->title ?> 
                                </span>
                            <?php endif; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
        <? endforeach; ?>
    </table>
</div>