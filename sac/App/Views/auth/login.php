<?php 
	require_once dirname(__FILE__).'/../layout.php';
	
	use App\Helpers\View;

	$aData 			= View::data();
	$aUser			= $aData['user'];
	$aUffs			= $aData['uffs'];
	$aPassword		= $aData['password'];
	$aIsLogin		= $aData['isLogin'];
?>

<div class="jumbotron">
	<div class="container">
		<h1>Login</h1>
		<p>Informe seus dados para efetuar login</p>
	</div>
</div>

<div class="container">
	<form class="form-horizontal" action="login" method="post" role="form">
		<div class="form-group">
			<div class="form-group  <?= $aData['loginError'] ? 'error' : '' ?> ">
				<label class="col-md-3 control-label">CPF</label>
				<div class="col-md-5">
					<input name="user" type="text" placeholder="Informe seu CPF" value="<?= $aUser ?>" class="form-control">
				</div>
			</div>
			
			<div class="form-group  <?= $aData['loginError'] ? 'error' : '' ?>  uffs" style="display:  <?= $aUffs == '1' ? 'block' : 'none' ?> ;">
				<label class="col-md-3 control-label">Senha*</label>
				<div class="col-md-5">
					<input name="password" type="password" placeholder="Senha de acesso"  value="<?= $aPassword ?>" class="form-control">
					<?= $aData['loginError'] ? '<span class="help-inline">Usuário ou senha inválidos.</span><br/>' : '' ?> 
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<button type="submit" class="btn btn-success">Entrar</button>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-5">
			<div class="alert alert-warning" role="alert"><strong>*OBS:</strong> Se você é aluno/professor da UFFS, use sua senha do <strong>Moodle</strong> para efetuar login.</div>
			<p>Em caso de problemas com o cadastro ou senha, escreva para <strong><a href="mailto:cacomputacaouffs@gmail.com">cacomputacao@gmail.com</a></strong>.</p>
		</div>
	</div>			
</div>