<?php
use App\Helpers\UtilsHelper;
use App\Models\User;
use App\Models\Payment;
?>

<div class="profile">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="profile__title title">Perfil</h1>
            </div>
            <div class="col text-right">
                <?php if ($user->hasPermission(User::USER_CO_ORGANIZER)): ?>
                <a href="<?= UtilsHelper::base_url("/admin") ?>" class="btn btn--medium btn--secondary">Dashboard</a>
                <?php endif; ?>
                <a href="<?= UtilsHelper::base_url("/logout") ?>" class="btn btn--medium btn--primary">Sair</a>
            </div>
        </div>
        <div class="profile__card">
            <h2 class="title">Dados</h2>
            <table class="table">
                <tr>
                    <th>Nome:</th>
                    <td><?= $user->name ?></td>
                </tr>
                <tr>
                    <th>E-mail:</th>
                    <td><?= $user->email ?></td>
                </tr>
                <tr>
                    <th>CPF:</th>
                    <?php if ($user->isInternal()): ?>
                    <td><?= $user->cpf ?></td>
                    <?php else: ?>
                    <td>
                        <form action="<?= UtilsHelper::base_url("/perfil/atualizar") ?>" method="post">
                            <input type="text" name="registration" value="<?= $user->registration ?>">
                            <button class="btn btn--primary btn--small">Salvar</button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php if ($user->isInternal()): ?>
                <tr>
                    <th>Matrícula:</th>
                    <td>
                        <form action="<?= UtilsHelper::base_url("/perfil/atualizar") ?>" method="post">
                            <input type="text" name="registration" value="<?= $user->registration ?>">
                            <button class="btn btn--primary btn--small">Salvar</button>
                        </form>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
        <div class="profile__card">
            <h2 class="title">Inscrições</h2>
            <?php if (count($user->getPayments())): ?>
                <?php foreach ($user->getPayments() as $payment): ?>
                <?php
                    $message = "Valor pago";
                    switch ($payment->type):
                    case 'subscription':
                        $message = "Inscrição no evento aprovada!";
                        break;
                    case 'event':
                        $message = "Inscrição na atividade <b>" . $payment->getEvent()->title . "</b>"; 
                        break;
                    ?>
                    <?php endswitch; ?>

                    <?php if ($payment->status == Payment::PAYMENT_CONFIRMED):?>
                        <div class="alert alert--success" role="alert">
                            <i class="fas fa-check"></i>
                            <?= $message ?> O valor pago foi R$ <?= number_format($payment->amount, 2, ',', '.'); ?>
                        </div>
                    <?php endif;?>

                <?php endforeach;  ?>
            </div>
            <?php else: ?>
                <div class="alert alert--warning" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    Nenhuma incrição confirmada até o momento. Por favor, contate o CA para efetuar o pagamento de sua inscrição.
                </div>
            <div>
            <div>
                <p>Confira a tabela de preços da semana acadêmica:</p>
                <table class="table table--lg table--bordered">
                    <tr class="bg-primary-light">
                        <!-- <th>Lote</th> -->
                        <?php if($user->isInternal()): ?>
                        <th>Estudante CC UFFS</th>
                        <!--<th>Estudante UFFS</th>-->
                        <?php else: ?>
                        <th>Visitante</th>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <!--<td><b>1º lote</b></td>-->
                        <?php if($user->isInternal()): ?>
                        <td>R$ 10,00</td>
                        <td>R$ 30,00</td>
                        <?php else: ?>
                        <!--<td rowspan="3">R$ 40,00</td>-->
                        <?php endif; ?>
                    </tr>
                   <!-- <tr>
                        <?php if($user->isInternal()): ?>
                        <td><b>2º lote</b></td>
                        <td>R$ 10,00</td>
                        <?php endif; ?>
                    </tr>-->
                    <!-- <tr>
                        <?php if($user->isInternal()): ?>
                        <td><b>No dia</b></td>
                        <td>R$ 15,00</td>
                        <? endif; ?>
                    </tr> -->
                </table>
            </div>
        </div>
        <br>
        <h2 class="title" scroll-sensitive="animate-top-down">Formas de pagamento</h2>
        <div class="row">
            <div class="col-lg-6">
                <h3 class="title text-center">Dinheiro</h3>
                <p>O pagamento deve ser feito via pix ou para membro do CA, para contatá-los envie um e-mail para <a href="mailto:cacomputacaouffs@gmail.com">cacomputacaouffs@gmail.com</a> ou entre em contato pelas redes sociais:</p>
                <p class="instagram">
                    <a href="https://www.instagram.com/caccuffs/" target="_blank">
                        <!-- <img src="https://imageog.flaticon.com/icons/png/512/174/174855.png?size=1200x630f&pad=10,10,10,10&ext=png&bg=FFFFFFFF" width="50"/> -->
                        caccuffs
                    </a>
                </p>
            </div>
            <div class="col-lg-6">
                <h3 class="title text-center">Transferência bancária</h3>
                <p class="text-center">Em breve...</p>
            </div>
        </div>
    </div>
            <?php endif; ?>
        </div>
    </div>
</div>
