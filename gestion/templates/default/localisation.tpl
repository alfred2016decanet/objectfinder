<form method="post" class="form-horizontal">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Localisation</h4>
            <p>Gérer vos Localisations</p>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="form-group">
                    <label for="form_iso_code" class="col-sm-3 control-label">Langue par défaut</label>
                    <div class="col-sm-3">
                        <select name="conf_default_lang" class="form-control">
                            {foreach from=$langues item=langue}
                                <option value="{$langue.id_lang}" {if $configs.default_lang eq $langue.id_lang}selected{/if}>{$langue.name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="conf_default_idlang" class="col-sm-3 control-label">Identifiant de la langue </label>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" name="conf_default_idlang" id="conf_default_idlang" value="{$configs.default_idlang}">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-9 col-sm-offset-3">
                    <button type="submit" name="submitLocalisation" class="btn btn-primary">
                        <i class="glyphicon glyphicon-save"></i>
                        Enregister
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>