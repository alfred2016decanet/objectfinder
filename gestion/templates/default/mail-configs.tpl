
<form method="post" class="form-horizontal">
	<div class="panel panel-danger">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="glyphicon glyphicon-cog"></i> Services Mail</h3>
		</div>
		<div class="panel-body">
			<div class="row-fluid">
				<div class="form-group">
					<label for="mail_serveur" class="col-sm-3 control-label">Serveur mail: </label>
					<div class="col-sm-3">
						<select name="mail_serveur" class="form-control">
							<option value="phpmail" {if $configs.mail_serveur eq 'phpmail'}selected{/if}>PHP Mail</option>
							<option value="sendmail" {if $configs.mail_serveur eq 'sendmail'}selected{/if}>Send Mail</option>
							<option value="smtp" {if $configs.mail_serveur eq 'smtp'}selected{/if}>SMTP</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="mail_sitemail" class="col-sm-3 control-label required">Email du site:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" required="" name="mail_sitemail" id="mail_sitemail" value="{$configs.mail_sitemail}">
					</div>
				</div>
				<div class="form-group">
					<label for="mail_sitemailname" class="col-sm-3 control-label required">Expéditeur:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" required="" name="mail_sitemailname" id="mail_sitemailname" value="{$configs.mail_sitemailname}">
					</div>
				</div>
				<div class="form-group">
					<label for="mail_authentification" class="col-sm-3 control-label">Autentification SMTP</label>
					<div class="col-sm-2">
						<input type="checkbox" class="form-control default-switch-field" name="mail_authentification" id="mail_authentification" value="1" {if $configs.mail_authentification}checked{/if}>
					</div>
				</div>
				<div class="form-group">
					<label for="mail_sercure" class="col-sm-3 control-label">Sécurité SMTP: </label>
					<div class="col-sm-2">
						<select name="mail_sercure" class="form-control">
							<option value="none" {if $configs.mail_sercure eq 'none'}selected{/if}>Aucune</option>
							<option value="ssl" {if $configs.mail_sercure eq 'ssl'}selected{/if}>SSL</option>
							<option value="tls" {if $configs.mail_sercure eq 'tls'}selected{/if}>TLS</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="mail_port" class="col-sm-3 control-label required">Port:</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" required="" name="mail_port" id="mail_port" value="{$configs.mail_port}">
					</div>
				</div>
				<div class="form-group">
					<label for="mail_user" class="col-sm-3 control-label required">Utilisateur SMTP:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" required="" name="mail_user" id="mail_user" value="{$configs.mail_user}">
					</div>
				</div>
				<div class="form-group">
					<label for="mail_pwd" class="col-sm-3 control-label required">Mot de passe SMTP:</label>
					<div class="col-sm-5">
						<input type="password" class="form-control" required="" name="mail_pwd" id="mail_pwd" value="{$configs.mail_pwd}">
					</div>
				</div>
				<div class="form-group">
					<label for="mail_host" class="col-sm-3 control-label required">Serveur SMTP:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" required="" name="mail_host" id="mail_sitemail" value="{$configs.mail_host}">
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
            <div class="row">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" name="submitMail" class="btn btn-primary">
                        <i class="glyphicon glyphicon-save"></i>
                        Enregister
                    </button>
                    <button type="submit" name="submitMailAndTest" class="btn btn-success">
                        <i class="glyphicon glyphicon-save"></i>
                        Tester l'envoi
                    </button>
                </div>
            </div>
		</div>
	</div>
</form>