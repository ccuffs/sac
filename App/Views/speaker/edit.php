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
        <a href="<?= UtilsHelper::base_url("/admin/palestrantes/{$speaker->id}") ?>" class="btn btn-success"> Voltar </a>
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
            
            <div class="col-sm-7 col-md-5">
                <div class="form-group">
                    <label> Imagem </label>
                    <div class="alert alert-warning">
                        Apenas insira uma foto caso queira substituir a atual.
                    </div>
                    <?php if (@$speaker->img_path): ?>
                    <img src="<?= UtilsHelper::storage_url(@$speaker->img_path) ?>" alt="<?= @$speaker->name ?> foto" style="width: 100%">
                    <br><br>
                    <?php endif; ?>
                    <input type="file" name="img"/>
                </div>
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label">Evento</label>
                    <select name="fk_event" class="form-control">
                        <option value=""></option>
                        <?php foreach($events as $event): ?>
                            <option 
                                <?= $speaker->fk_event == $event->id ? "selected" : "" ?>
                            value="<?= $event->id ?>"> <?= $event->title ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
            
        </form>
    </div>
    
</div>