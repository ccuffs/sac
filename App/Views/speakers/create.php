<?php 
use App\Models\User;
use App\Models\Event;
use App\Helpers\View;
use App\Helpers\UtilsHelper;

$data
?>


<div class="jumbotron">
    <div class="container">
        <h1> Palestrantes </h1>
        <p>Adicionar, remover ou alterar informações dos palestrantes. </p>
    </div>
</div>

<div class="container">
    <div>
        <a href="<?= UtilsHelper::base_url("/admin/palestrantes") ?>" class="btn btn-success"> Voltar </a>
    </div>

    <div class="row">
        <form class="mt-4" method="post" enctype="multipart/form-data">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="control-label"> Nome </label>
                    <input required type="text" name="name" class="form-control" />
                </div>                
                <input type="file" name="img" class="mt-10"/>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label> Descrição </label>
                    <textarea class="form-control" name="description" rows="5"></textarea>
                </div>
            </div>
            
            <div class="col-md-7">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
            
        </form>
    </div>
    
</div>