<?php
    use App\Helpers\View;
    use App\Models\User;
    
    $aData = View::data();
?>

    <div class="jumbotron">
        <div class="container">
            <h2>Permissões</h2>
            <p>Alterar permissões de usuário.</p>
        </div>
    </div>

    <div class="container user-permission">
        <div class="row">
            <?php foreach ($aData['users'] as $user): ?>
            <div class="col-md-3">
                <div class="card mt-15 
                    <?php 
                            if($user->isLevel(User::USER_LEVEL_ADMIN)){
                                echo 'bg-info';
                            }
                            else if ($user->isLevel(User::USER_CO_ORGANIZER)){
                                echo 'bg-success';
                            }
                            else if ($user->isLevel(User::USER_LEVEL_UFFS)){
                                echo 'bg-warning';
                            }
                            else {
                                echo 'bg-danger';
                            }
                            
                    ?> 
                ">
                        <input type="hidden" value="<?= $user->id ?>"/>
                        <div class="card-body mt-5">
                            <div class="card-image">
                                <img src="http://avatars.io/email" alt="moodle-img" />
                        </div>

                            <div class="card-content center">
                                <p class="mt-5 light strong">
                                    <?= $user->name ?>
                                </p>
                                <a href="mailto:<?= $user->email ?>" title="Semana Acadêmica" class="light">
                                    <?= $user->email ?>
                                </a>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group light center mt-5">
                                <?php if($aData['authUser']->isLevel(User::USER_LEVEL_ADMIN)): ?>
                                    <label for="permission"> Permissão</label>
                                    <select class="form-control permission">
                                        <option value = 4 <?php if($user->isLevel(User::USER_LEVEL_ADMIN)) echo 'selected'; ?>>Administrador</option>
                                        <option value = 3 <?php if($user->isLevel(User::USER_CO_ORGANIZER)) echo 'selected'; ?>>Co-organizador</option>
                                        <option value = 2 <?php if($user->isLevel(User::USER_LEVEL_UFFS)) echo 'selected' ?>>Estudante UFFS</option>
                                        <option value = 1 <?php if($user->isLevel(User::USER_LEVEL_EXTERNAL)) echo 'selected' ?>>Comunidade Externa</option>
                                    </select>
                                <?php else: ?>
                                    <div> <?php if($user->isLevel(User::USER_LEVEL_ADMIN)) echo 'Administrador'; ?> </div>
                                    <div> <?php if($user->isLevel(User::USER_CO_ORGANIZER)) echo 'Organizador'; ?> </div>
                                    <div> <?php if($user->isLevel(User::USER_LEVEL_UFFS)) echo 'Comunidade UFFS' ?> </div>
                                    <div> <?php if($user->isLevel(User::USER_LEVEL_EXTERNAL)) echo 'Comunidade Externa' ?> </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <script type="text/javascript" content="text/html; charset=utf-8">
        SAC.userPermission();
    </script>