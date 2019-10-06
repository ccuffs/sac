<?php
use App\Helpers\UtilsHelper;
?>

<div class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="login">
                    <div class="login__logo">
                        <img src="<?= UtilsHelper::base_url("/img/logo.png")?>" alt="Logo SACC">
                    </div>
                    <h2 class="login__title">Visitante - Inscrição</h2>
                    <form class="login__form" method="post">
                        <div class="form__content">
                            <input type="text" required class="form__input" name="name" placeholder="Nome">
                        </div>
                        <div class="form__content">
                            <input type="email" required class="form__input" name="user" placeholder="E-mail">
                        </div>
                        <div class="form__content">
                            <input type="password" required class="form__input" name="password" placeholder="Senha">
                        </div>
                        <div class="form__content">
                            <input type="password" required class="form__input" name="password_confirm" placeholder="Confirmar senha">
                        </div>
                        <div>
                            <button type="submit" class="btn btn--primary btn--fluid">Registrar</button>
                        </div>
                    </form>
                    <div class="form__resources">
                        <a class="resources__anchor" href="<?= UtilsHelper::base_url("/login")?>">
                            Estudante UFFS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
