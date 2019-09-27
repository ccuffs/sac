<?php
use App\Models\Event;
use App\Helpers\UtilsHelper;
?>

<div class="jumbotron">
    <div class="container">
        <h1>Competições</h1>
        <p>Editar competições.</p>
    </div>
</div>

<div class="container">
    <div>
        <a href="<?= UtilsHelper::base_url("/admin/campeonato/" . $competition->id) ?>" class="btn btn-default">Voltar</a>
    </div>
    <br>

    <div class="row">
    <form class="col-md-8" method="post">
        <div class="form-group">
            <label class="control-label">Título</label>
            <input required type="text" name="title" class="form-control" />
        </div>
            
        <div class="form-group">
            <label class="control-label">Headline</label>
            <input required type="text" name="headline" class="form-control" />
        </div>

        <div class="form-group">
            <label class="control-label">Prêmio</label>
            <input required type="text" name="prizes" class="form-control" />
        </div>

        <div class="form-group">
            <label class="control-label">Regras</label>
            <textarea required name="rules" class="form-control" rows="4"></textarea>
        </div>
        
        <div class="form-group">
            <label class="control-label">Descrição</label>
            <textarea required name="description" class="form-control" rows="4"></textarea>
        </div>
        
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-7">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
    </form>
    </div>

</div>