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
        <a href = "<?= UtilsHelper::base_url("/admin/speakers/create") ?>" class="btn btn-success">Adicionar</a>
    </div>
    <br>

    <table class="table table-striped">

        <tr>
            <th> Nome </th>
            <th> Descrição </th>
        </tr>

        <tr>
            <td> Olá  </td>
            <td> Mundo </td>
        </tr>
    </table>
</div>