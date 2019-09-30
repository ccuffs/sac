<?php
use App\Helpers\UtilsHelper;
?>

<div class="profile">
    <div class="container">
        <h1 class="profile__title title">Perfil</h1>
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
                        $message = "Inscrição na atividade"; 
                        break;
                    ?>
                    <?php endswitch; ?> 
                    R$ <?= number_format($payment->amount, 2, ',', '.'); ?>: <?= $message ?>
                </li>
                <?php endforeach;  ?>
            </ul>
        </div>
    </div>
</div>
