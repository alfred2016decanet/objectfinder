<div class="panel panel-danger">
    <ul class="panel-options">
        <li><a href="gestionnaires.html"><i class="fa fa-refresh"></i></a></li>
        <li><a class="panel-minimize"><i class="fa fa-chevron-down"></i></a></li>
        {if $udroits.add_2_2 || $currentuserinfos.access_all}
            <li><a href="edit-gestionnaire.html" class="" title="Ajouter"><i class="fa fa-plus"></i></a></li>
        {/if}
    </ul>
    <div class="panel-heading">
        <h4 class="panel-title">Gestionnaires</h4>
        <p>Gérer vos administrateurs</p>
    </div>
    <div class="panel-body">
       <div class="row">
            <form method="post" class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input class="form-control" value="{if !empty($filters.search)}{$filters.search}{/if}" name="search" type="text" placeholder="nom, prenom">
                </div>
                <button class="btn btn-default" name="submitFilter" type="submit">rechercher</button>
            </form>
            {assign var='prevpage' value=$currpage-1}
            {assign var='nextpage' value=$currpage+1}
            <div class="btn-toolbar pull-right">
                <a class="btn btn-default" href="{if $prevpage eq 0}#{else}gestionnaires.html?p={$prevpage}{/if}" title="Précedent"><i class="fa fa-angle-left"></i></a>
                <a class="btn btn-default"  href="#">{$currpage}/{$nbpages}</a>
                <a class="btn btn-default"  href="{if $currpage >= $nbpages}#{else}gestionnaires.html?p={$nextpage}{/if}" title="suivant"><i class="fa fa-angle-right"></i></a>
            </div>
            {*<ul class="nav navbar-nav navbar-right pager">
                <li {if $prevpage eq 0}class="disabled"{/if}></li>   
                <li class="active" role="presentation">
                    
                </li>
                <li {if $currpage >= $nbpages}class="disabled"{/if}></li> 
            </ul> *}
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-striped nomargin">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Photo</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th class="text-center">Identifiant</th>
                            <th class="text-center">Activer</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {if is_array($gestionnaires) AND $gestionnaires|count}
                            {foreach from=$gestionnaires item=gestionnaire}
                                <tr id="{$gestionnaire.id}">
                                    <td class="text-center">{$gestionnaire.id}</td>
                                    <td class="text-center"> <img src="/data/img/gestionnaires/{$gestionnaire.id}/{$gestionnaire.photo}" class="img-thumbnail img-circle" style="width: 50px;" alt="image"></td>
                                    <td>{$gestionnaire.nom}</td>
                                    <td>{$gestionnaire.prenom}</td>
                                    <td class="text-center">{$gestionnaire.identifiant}</td>
                                    <td class="text-center">
                                        <a id="validate_{$gestionnaire.id}" class="btn btn-{if $gestionnaire.active}success{else}danger{/if}" onclick="toggleActivate('{$gestionnaire.id}');return false;">
                                            <span class="glyphicon glyphicon-{if $gestionnaire.active}ok{else}remove{/if}" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        {if $udroits.edit_2_2 || $udroits.del_2_2 || $currentuserinfos.access_all}
                                            <div class="btn-group-action">
                                                <div class="btn-group">
                                                    <a class="edit btn btn-default {if $udroits.edit_2_2 || $currentuserinfos.access_all}ok{else}disable{/if}" title="Modifier" href="edit-gestionnaire.html?id={$gestionnaire.id}">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                        Modifier
                                                    </a>
                                                    <button class="btn btn-default dropdown-toggle" aria-expanded="false" data-toggle="dropdown" type="button">
                                                        <span class="caret"></span>&nbsp;
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                        {if $udroits.del_7_2 || $currentuserinfos.access_all}
                                                            <li>
                                                                <a href="#" onclick="suppr_entree('gestionnaire', '{$gestionnaire.id}');return false;">
                                                                    <i class="glyphicon glyphicon-trash"></i>
                                                                    Supprimer
                                                                </a>
                                                            </li>
                                                        {/if}
                                                    </ul>
                                                </div>
                                            </div>
                                        {/if}
                                    </td>
                                </tr>
                            {/foreach}   
                        {else}
                            <tr>
                                <td colspan="6"> Aucun enregistrement pour le moment!</td>
                            </tr>
                        {/if}  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

