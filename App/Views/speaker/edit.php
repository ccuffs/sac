<?php 
use App\Models\User;
use App\Models\Speaker;
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
        <a href="<?= UtilsHelper::base_url("/admin/palestrantes") ?>" class="btn btn-success"> Voltar </a>
    </div>
    <br>

    <div class="row">
        <form method="post" enctype="multipart/form-data">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label"> Nome </label>
                    <input required type="text" name="name" value="<?= @$speaker->name ?>" class="form-control" />
                </div>                
            </div>
            
            <div class="col-md-8">
                <div class="form-group">
                    <label> Descrição </label>
                    <textarea class="form-control" name="description" rows="5"><?= @$speaker->description ?></textarea>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="form-group">
                    <label> Imagem </label>
                    <div class="alert alert-warning">
                        Apenas insira uma foto caso queira substituir a atual.
                    </div>
                    <?= @$speaker->img_path ?>
                    <input type="file" name="img"/>
                </div>
            </div>

            <div class="col-md-7">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
            
        </form>
    </div>
    
</div>