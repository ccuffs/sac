<?php
use App\Models\Event;
use App\Helpers\UtilsHelper;
?>

<div class="jumbotron">
    <div class="container">
        <h1>Eventos</h1>
        <p>Editar eventos.</p>
    </div>
</div>

<div class="container">
    <div>
        <a href="<?= UtilsHelper::base_url("/admin/evento") ?>" class="btn btn-default">Voltar</a>
    </div>
    <br>

    <div class="row">
    <form class="col-md-8" method="post">
        <div class="form-group">
            <label class="control-label">Título</label>
            <input required type="text" name="title" value="<?= @$competition->title ?>" class="form-control" />
        </div>
                
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Dia</label>
                    <input required type="number" name="day" value="<?= @$competition->day ?>" class="form-control">
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Mês</label>
                    <input required type="number" name="month" value="<?= @$competition->month ?>" class="form-control">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Horário</label>
                    <input required type="text" name="time" value="<?= @$competition->time ?>" class="form-control">
                </div>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Local</label>
                    <input required type="text" name="place" value="<?= @$competition->place ?>" class="form-control">
                </div>
            </div>

            <div class="col-md-3">
                <label class="control-label">Fantasma</label>
                <select required name="ghost" class="form-control">
                    <option value="0" <?= @$competition->ghost == 0 ? 'selected' : '' ?>>Não</option>
                    <option value="1" <?= @$competition->ghost != 0 ? 'selected' : '' ?>>Sim</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Custo</label>
                    <input required type="text" name="price" value="<?= @$competition->price ?>" class="form-control">
                </div>
            </div>
        </div>
        
        <div class="row">
        </div>
            
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Vagas</label>
                    <input required type="number" name="capacity" value="<?= @$competition->capacity ?>" class="form-control">
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Vagas (espera)</label>
                    <input required type="number" name="waiting_capacity" value="<?= @$competition->waitingCapacity ?>" class="form-control">
                </div>
            </div>

            <div class="col-md-4">
                <label class="control-label">Competição?</label>
                <select name="fk_competition" class="form-control">
                    <option value=""></option>
                    <?php foreach($competitions as $id => $competition): ?>
                        <option value="<?= $id ?>" <?= (@$competition->fk_competition == $id ? 'selected="selected"' : '') ?>> <?= $competition['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label">Descrição</label>
            <textarea required name="description" class="form-control" style="height: 300px;"><?= @$competition->description ?></textarea>
        </div>
        
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-7">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
    </form>
    </div>

</div>