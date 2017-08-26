
<div class="panel panel-danger">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i> Gestionnaires</h4>
        <p>Edtion d'un Gestionnaire</p>
    </div>
    <div class="panel-body">
        <form method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="form_nom" class="col-sm-3 control-label">Nom<sup>*</sup></label>
                    <div class="col-sm-9">
                        <input type="text" required="" class="form-control" name="form_nom" id="form_nom" placeholder="nom" value="{$gestionnaire.nom}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="form_prenom" class="col-sm-3 control-label">Prenom<sup>*</sup></label>
                    <div class="col-sm-9">
                        <input type="text" required="" class="form-control" name="form_prenom" id="form_prenom" placeholder="prenom" value="{$gestionnaire.prenom}">
                    </div>
                </div>
                {if $currentuserinfos.access_all}
                    <div class="form-group">
                        <label for="form_prenom" class="col-sm-3 control-label">Super utilisateur</label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <input type="radio" name="form_access_all" {if $currentuserinfos.access_all eq 1}checked=""{/if} value="1"> Oui
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="form_access_all" {if $currentuserinfos.access_all eq 0}checked=""{/if} value="0"> Non
                            </label>
                        </div>
                    </div>
                {/if}
                <div class="form-group">
                    <label for="form_identifiant" class="col-sm-3 control-label">Identifiant<sup>*</sup></label>
                    <div class="col-sm-9">
                        <input autocomplete="off" type="text" required="" class="form-control" name="form_identifiant" id="form_identifiant" placeholder="identifiant" value="{$gestionnaire.identifiant}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="form_mdp" class="col-sm-3 control-label">Mot de passe<sup>**</sup></label>
                    <div class="col-sm-9">
                        <input autocomplete="off" type="password" class="form-control" name="form_mdp" id="form_mdp" placeholder="Mot de passe" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="groupe" class="col-sm-3 control-label">Groupe<sup>*</sup></label>
                    <div class="col-sm-9">
                        <select name="groupe" class="form-control">
                            <option value="0"></option>
                            {if is_array($groupes) AND $groupes|count}
                                {foreach from=$groupes item=groupe}
                                    <option value="{$groupe.id}" {if $gestionnaire.id_groupe eq $groupe.id}selected{/if}>{$groupe.nom}</option>
                                {/foreach}
                            {/if}
                        </select>
                    </div>
                </div>		
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <img id="img-thumbnail" src="{if $gestionnaire.photo != ''}/data/img/gestionnaires/{$gestionnaire.id}/{$gestionnaire.photo}{/if}" class="img-responsive img-thumbnail" alt="Responsive image">
                </div>
                <div class="form-group">
                    <label for="photo">Logo</label>
                    <input id="photo" name="photo" type="file">
                    <input id="form_photo" name="form_photo" type="hidden">
                </div>
                <div class="form-group">
                    <button type="submit" name="submitGestionnaire" class="btn btn-success btn-quirk btn-wide mr5">Enregister</button>
                    <a class="btn btn-quirk btn-wide btn-default" href="gestionnaires.html">Annuler</a>
                </div>
            </div>  
        </form>
    </div>
</div>



