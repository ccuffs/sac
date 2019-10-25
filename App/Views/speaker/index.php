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
                <td width="50"><a href="<?= UtilsHelper::base_url("/admin/palestrantes/" . $speaker->id) ?>" class="btn btn-primary">Visualizar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>