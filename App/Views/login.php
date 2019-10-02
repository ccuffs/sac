<?php
use App\Helpers\UtilsHelper;
?>

<div class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="login ">
                    <div class="login__logo">
                        <img src="<?= UtilsHelper::base_url("/img/logo.png")?>" alt="Logo SACC">
                    </div>
                    <h2 class="login__title">Entre com seu idUFFS</h2>
                    <div class="login__form">
                        <form class="form" method="post">
                            <div class="form__content">
                                <input type="text" class="form__input" name="user" id="idName"
                                    placeholder="IdUFFS">
                            </div>
                            <div class="form__content">
                                <input type="password" class="form__input" name="password" id="idPass"
                                    placeholder="Senha">
                            </div>
                            <div class="form__check">
                                <input type="checkbox" class="form__check" name="txtCheck" id="idCheck">
                                <label for="idCheck">Lembrar meu usuário</label>
                            </div>
                            <div class="form__btn">
                                <button type="submit" class="btn btn--primary btn--fluid" name="txtBtn" id="idBtn">entrar</button>
                            </div>

                        </form>
                        <div class="form__resources">
                            <a class="resources__anchor"href="https://id.uffs.edu.br/id/XUI/?realm=/#forgotUsername/" target="_blanck">
                                Não sabe seu idUFFS?
                            </a>
                            <a class="resources__anchor" href="https://id.uffs.edu.br/id/XUI/?realm=/#passwordReset/ " target="_blanck">
                                Esqueceu a Senha?
                            </a>
                            <a class="resources__anchor" href="https://ati.uffs.edu.br/public.pl?CategoryID=17" target="_blanck">
                                Ajuda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
