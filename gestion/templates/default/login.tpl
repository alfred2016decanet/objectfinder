
<div class="panel signin">
    <div class="text-center"><img src="/assets/img/logo.png"></div>
    {if isset($error)}
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Erreur : </strong> {$error}
        </div>
    {/if}
    {if isset($lostpassword)}
        <div id="resetpswd-form">
            <div class="panel-heading">
                    <h1>Espace client</h1>
                    <h4 class="panel-title">Réinitialisation de mot de passe</h4>
            </div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group mb10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" name="mdpass1" class="form-control" placeholder="Saisissez votre nouveau mot de passe" required aria-required="true">
                        </div>
                    </div>
                    <div class="form-group mb10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" name="mdpass2" class="form-control" placeholder="Saisissez le à nouveau" required aria-required="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-quirk btn-block" name="resetpswd">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
        {else}
        <div id="login-form" {if isset($hidden_block) && $hidden_block == 'login'} class="hidden"{/if}>
            <div class="panel-heading">
                <h1>Espace client</h1>
                <h4 class="panel-title">Bonjour ! Veuillez-vous identifier.</h4>
            </div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group mb10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="email" class="form-control" placeholder="Saisissez votre identifiant">
                        </div>
                    </div>
                    <div class="form-group nomargin">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" name="mdpasse" class="form-control" placeholder="Saisissez votre mot de passe">
                            <input type="hidden" name="back" id="back" value="{$s_config.back}">
                        </div>
                    </div>
                    <div><a href="#" class="forgot">Mot de passe oublié ?</a></div>
                    <div class="form-group">
                        <button class="btn btn-success btn-quirk btn-block" name="login">Connexion</button>
                        {*<a href="index.php?controller=signup" class="btn btn-success btn-quirk btn-block btn-stroke" name="signup">Pas encore client ? Créer un compte</a>*}
                    </div>
                </form>
            </div>
        </div>
        <div id="forgetpswd-form" {if !isset($hidden_block) || $hidden_block != 'login'} class="hidden"{/if}>
            <div class="panel-heading">
                <h1>Espace client</h1>
                <h4 class="panel-title">Mot de passe oublié ?</h4>
                <h6 class="">Préciser votre email, un message vous sera envoyé avec le lien de réinitialisation.</h6>
            </div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group mb10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="email" class="form-control" value="{if isset($email)}{$email}{/if}" placeholder="Saisissez votre email" required="" aria-required="true">
                        </div>
                    </div>
                    <div><a href="" class="forgot">Revenir au formulaire de connexion</a></div>
                    <div class="form-group">
                        <button class="btn btn-success btn-quirk btn-block" name="forgetpswd">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    {/if}
</div><!-- panel -->