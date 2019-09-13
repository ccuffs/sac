<?php 
	require_once dirname(__FILE__).'/../layout.php';
	
	use App\Helpers\View;

	$aData 			= View::data();
	$aUser			= $aData['user'];
	$aUffs			= $aData['uffs'];
	$aEmail			= $aData['email'];
	$aName			= $aData['name'];
	$aPassworde		= $aData['passworde'];
	$aPassword		= $aData['password'];
	$aIsLogin		= $aData['isLogin'];
	
	layoutHeader($aIsLogin ? 'Login' : 'Inscrição');
?>
<div class="jumbotron">
    <div class="container">
        <h1>Inscrição</h1>
        <p>Informe seus dados para efetuar login</p>
    </div>
</div>

<div class="container">
    <form class="form-horizontal" method="post" role="form">
    <div class="form-group">
        <div class="form-group  <?= $aData['loginError'] ? 'error' : '' ?> ">
        <label class="col-md-3 control-label">CPF</label>
        <div class="col-md-5">
            <input name="user" type="text" placeholder="Informe seu CPF" value="<?= $aUser ?>" class="form-control">
        </div>
        </div>
        
            <div class="form-group">
            <label class="col-md-3 control-label">Aluno/professor da UFFS?</label>
            <div class="col-md-5">
                <select name="uffs" id="uffs" onchange="SAC.registrationToggleFields();">
                    <option value="1"  <?= $aUffs == '1' ? 'selected="selected"' : '' ?> >Sim</option>
                    <option value="0"  <?= $aUffs == '0' ? 'selected="selected"' : '' ?> >Não</option>
                </select>
            </div>
            </div>
            <div class="form-group  <?= $aData['loginError'] ? 'error' : '' ?> ">
            <label class="col-md-3 control-label">E-mail</label>
            <div class="col-md-5">
                <input name="email" type="text" placeholder="E-mail para contato"  value="<?= $aEmail ?>" class="form-control">
            </div>
            </div>
            <div class="form-group  <?= $aData['loginError'] ? 'error' : '' ?>  nao-uffs" style="display:  <?= $aUffs == '0' ? 'block' : 'none' ?> ;">
            <label class="col-md-3 control-label">Nome</label>
            <div class="col-md-5">
                <input name="name" type="text" placeholder="Informe seu nome completo"  value="<?= $aName ?>" class="form-control">
                <?= @$aData['loginError'] ? '<span class="help-inline">O nome precisa ter no mínimo alguns caracteres.</span><br/>' : '' ?> 
            </div>
            </div>
            <div class="form-group  <?= $aData['loginError'] ? 'error' : '' ?>  nao-uffs" style="display:  <?= $aUffs == '0' ? 'block' : 'none' ?> ;">
            <label class="col-md-3 control-label">Senha</label>
            <div class="col-md-5">
                <input name="passworde" type="password" placeholder="Informe uma senha para o seu cadastro"  value="<?= $aPassworde ?>" class="form-control">
                <?= @$aData['loginError'] ? '<span class="help-inline">A senha precisa ter no mínimo alguns caracteres.</span><br/>' : '' ?> 
            </div>
            </div>
        
        <div class="form-group  <?= $aData['loginError'] ? 'error' : '' ?>  uffs" style="display:  <?= $aUffs == '1' ? 'block' : 'none' ?> ;">
        <label class="col-md-3 control-label">Senha*  <?= $aIsLogin ? '' : 'do Moodle' ?> </label>
        <div class="col-md-5">
            <input name="password" type="password" placeholder=" <?= $aIsLogin ? 'Senha de acesso (use a do Moodle se você é da UFFS)' : 'Senha de acesso' ?> "  value="<?= $aPassword ?>" class="form-control">
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

<?php layoutFooter();?>