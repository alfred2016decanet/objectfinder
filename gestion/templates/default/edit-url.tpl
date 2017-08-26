<form method="post" class="form-horizontal" enctype="multipart/form-data">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="glyphicon glyphicon-cog"></i>  Gestion des URLEdition d'une url</h4>
            <p>Edition d'une url</p>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="form-group">
                    <label for="form_name" class="col-sm-2 control-label">Titre</label>
                    <div class="col-sm-4 ">
                        {foreach from=$langues item=langue}
                            {assign var='langid' value=$langue.id_lang}
                            <div class="input-group translatable-field lang-{$langue.id_lang}">
                                <input id="name_{$langue.id_lang}" class="form-control" type="text" required="required" value="{$url.name.$langid}" name="lang_{$langue.id_lang}_name">
                                <div class="input-group-btn">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" tabindex="-1" type="button">
                                        {$langue.iso_code}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        {foreach from=$langues item=lang}
                                            <li>
                                                <a tabindex="-1" href="javascript:hideOtherLanguage({$lang.id_lang});">{$lang.name}</a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>

                <div class="form-group">
                    <label for="form_page" class="col-sm-2 control-label">Page</label>
                    <div class="col-sm-3">
                        <select name="form_page" class="form-control">
                            {foreach from=$pages item=page}
                                <option value="{$page.nom}" {if $page.nom eq $url.page}selected{/if}>{$page.nom}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="form_page" class="col-sm-2 control-label">Banière</label>
                    <div class="col-sm-3">
                        {if !empty($url.baniere)}
                            <img class="img-responsive" src="{$image_path}/{$url.baniere}"/>
                        {/if}
                        <input type="file" name="baniere"/>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submitUrl" class="btn btn-primary">
                        <i class="glyphicon glyphicon-save"></i>
                        Enregister
                    </button>
                    <a class="btn btn-default" href="liste-urls.html">Annuler</a>
                </div>
            </div>
        </div>
    </div>
</form>
