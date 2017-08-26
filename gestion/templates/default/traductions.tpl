
<div class="panel">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="glyphicon glyphicon-globe"></i> {l s='Langue'}</h4>
            <p>Gerer vos  Traductions</p>
        </div>
        <div class="panel-body">
            <form action="" method="get">
                <div class="form-group">
                    <label for="form_lang" class="col-sm-4 control-label">{l s='Veuillez séléctionner une langue :'}</label>
                    <div class="col-sm-3">
                        <select name="lang" class="form-control text-language">
                            <option value="0">{l s='Aucune langue'}</option>
                            {foreach from=$langues item=l}
                                <option value="{$l.iso_code|upper}" {if {{$l.iso_code|upper}} eq $lang}selected{/if}>{$l.name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-primary" type="submit" value="Afficher">{l s='Afficher'}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
{if $lang}
        <form action="" method="post">
            {foreach from=$translations key=translations_file item=translations_text}
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">{$translations_file}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-fields">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <h4>{l s='Texte'}</h4>
                                </div>
                                <div class="col-sm-6">
                                    <h4>{l s='Traduction'}</h4>
                                </div>
                            </div><br>
                            <hr class="header-line">
                            {foreach from=$translations_text key=ind item=t}
                                <br>
                                <div class="form-group">
                                    <label for="form_lang_{$t.nom|truncate:5:''}_{$ind}" class="col-sm-6 control-label">{$t.text|encode}</label>
                                    <div class="col-sm-6">
                                        <textarea rows="10" cols="25" id="form_lang_{$t.nom|truncate:5:''}_{$ind}" name="{$t.nom}" style="height:30px">{$t.trad}</textarea>
                                    </div>
                                </div>
                            {/foreach}
                            <br>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" name="envoi" class="btn btn-primary pull-right">
                                <i class="glyphicon glyphicon-save"></i>
                                {l s='Sauvegarder'}
                            </button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            {/foreach}
        </form>
    {/if}
</div>
