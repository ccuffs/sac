<?php 
use App\Models\User;
use App\Helpers\View;
use App\Helpers\UtilsHelper;  
?>
	
	<div class="jumbotron">
		<div class="container">
			<h1>Pagamentos</h1>
			<p>Adicionar ou remover pagamentos de usuários.</p>
		</div>
	</div>
	
	<div class="container">
	
	<!-- if (isset($aData['createdOrUpdated'])) {
		if ($aData['createdOrUpdated'] == true) {
			<div class="alert alert-success"><strong>Tudo certo!</strong> Operação realizada com sucesso!</div>
			
		} else {
			<div class="alert alert-danger"><strong>Oops!</strong> Alguma coisa saiu errada.</div>
		}
	} -->

	<form method="post">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Tipo de cadastro</label>
					<select payment-select-method class="col-lg-6 form-control">
						<option value="id">Usuário</option>
						<option value="cpf">Cpf</option>
					</select>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-4" payment-show-method="id">
				<div class="form-group">
					<label class="control-label">Usuário</label>
					<select name="fk_user" class="col-lg-6 form-control">
						<option value=""></option>
						<?php foreach($users as $user): ?>
							<option value="<?= $user->id ?>">
                                <?= $user->name ?>
                            </option>
                        <?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="col-md-4 hidden" payment-show-method="cpf">
				<div class="form-group">
					<label class="control-label">Cpf</label>
					<input type="text" name="cpf" class="col-lg-6 form-control" /><br/>
				</div>
			</div>
		
			<div class="col-md-2">
				<div class="form-group">
					<label class="control-label">Valor</label>
					<input type="text" name="amount" class="col-lg-6 form-control" /><br/>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Comentário</label>
					<input type="text" name="comment" class="col-lg-6 form-control" /><br/>
				</div>
			</div>
			
			<div class="col-md-1">
				<div class="form-group">
				<label class="control-label"></label>
					<input type="submit" name="submit" value="Adicionar pagamento" class="btn btn-success" />
				</div>
			</div>
		</div>
	</form>
	
	<div class="row" style="margin-top: 50px;">
		<div class="col-md-12">
			<div class="panel panel-default item-descriptor">
				<div class="panel-heading"><strong>Pagamentos</strong></div>
				<div class="panel-body">
					<table class="table table-hover">
						<thead>
							<th>Vínculo</th>
							<th>Usuário</th>
							<th>CPF</th>
							<th>Data</th>
							<th>Comentário</th>					
							<th>Valor</th>					
							<th></th>
						</thead>
						<tbody>
							<?php foreach($payments as $payment): ?>
								<tr>
									<td><?= $payment->user->getBond() ?></td>
									<td>
                                        <?= $payment->user->name ?>
                                        <?php if ($payment->user->isLevel(User::USER_LEVEL_ADMIN)): ?>
                                        <span class="label label-info">Admin</span>
                                        <?php endif; ?>
                                    </td>
									<td><?= $payment->user->cpf ?></td>
									<td><?= date('d/m/Y', $payment->date) ?></td>
									<td><?= $payment->comment ?></td>
									<td>R$ <?= sprintf('%.2f', $payment->amount) ?></td>
									<td><a href="<?= UtilsHelper::base_url("/admin/pagamento/{$payment->id}/delete") ?>" title="Apagar pagamento"><i class="fa fa-trash-o"></i></a></td>
								</tr>
                            <?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</div>

<script src="<?= UtilsHelper::base_url("/js/payment.js") ?>"></script>