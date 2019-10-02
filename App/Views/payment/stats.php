<?php
use App\Models\User;
use App\Helpers\View;
?>

<div class="jumbotron">
	<div class="container">
		<h1>Cadastros</h1>
		<p>Lista de participantes do evento.</p>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default item-descriptor">
				<div class="panel-heading"><strong>Informações</strong></div>
				<div class="panel-body dashboard-registration">
					<p><strong>R$ <?= sprintf('%0.2f', $total_paid)?></strong><br/>Total pago</p>
					<p><strong><?= $users_paid_total?></strong><br/>Pagantes</p>
					<p><strong><?= $users_nonpaid_total?></strong><br/>Não pagantes</p>
					<p><strong><?= $users_insiders?></strong><br/>Inscritos UFFS</p>
					<p><strong><?= $users_outsiders?></strong><br/>Inscritos Externos</p>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default item-descriptor">
				<div class="panel-heading"><strong>Inscritos</strong></div>
				<div class="panel-body">
					<table class="table table-hover">
						<thead>
							<th style="width: 40%;">Nome</th>
							<th style="width: 25%;">CPF / Login UFFS</th>
							<th style="width: 25%;">E-mail</th>
							<th style="width: 5%;">Vínculo</th>
							<th style="width: 5%;">Valor pago</th>

						</thead>
						<tbody>
							<?php foreach($users as $user): ?>
								<tr>
									<td><?= ($user->isLevel(User::USER_LEVEL_ADMIN) ? '<span class="label label-info">Admin</span> ' : '') . $user->name?></td>
									<td><?= $user->login?></td>
									<td><?= $user->email?></td>
									<td><?= $user->getBond()?></td>
									<td>
										<?php if ($user->getTotalPaid() > 0): ?>
											<span class="label label-success">Sim R$ <?= sprintf('%.2f', $user->getTotalPaid())?></span>
										<?php else: ?>
											<span class="label label-danger">Não</span>
										<?php endif; ?>
									</td>
								</tr>
								<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>