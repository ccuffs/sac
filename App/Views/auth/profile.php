<?php
use App\Helpers\UtilsHelper;
use App\Models\Event;
use App\Models\Payment;
?>

<div class="profile">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="profile__title title">Perfil</h1>
            </div>
            <div class="col text-right">
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
                    <td><?= $user->cpf ?></td>
                </tr>
            </table>
        </div>
        <div class="profile__card">
            <h2 class="title">Inscrições</h2>
            <?php if (count($user->getPayments())): ?>
            <ul>
                <?php foreach ($user->getPayments() as $payment): ?>
                <li>
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
                    R$ <?= number_format($payment->amount, 2, ',', '.'); ?>: <?= $message ?>
                </li>
                <?php endforeach;  ?>
            </ul>
            <?php else: ?>
                Nenhuma incrição confirmada até o momento. <br>
                Por favor, contate o CA para efetuar o pagamento de sua inscrição.
            <?php endif; ?>
        </div>
    </div>
</div>
