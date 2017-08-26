<div class="panel panel-danger">
     <ul class="panel-options">
        <li>
            <a href="edit-groupe.html" class="panel-remove" title="Ajouter">
                <i class="fa fa-plus"></i>
            </a>
        </li>
    </ul>
    <div class="panel-heading">
        <h4 class="panel-title">Groupes</h4>
        <p>Gérer vos groupes utilisateurs</p>
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
                <a class="btn btn-default" href="{if $prevpage eq 0}#{else}groupes.html?p={$prevpage}{/if}" title="Précedent"><i class="fa fa-angle-left"></i></a>
                <a class="btn btn-default"  href="#">{$currpage}/{$nbpages}</a>
                <a class="btn btn-default"  href="{if $currpage >= $nbpages}#{else}groupes.html?p={$nextpage}{/if}" title="suivant"><i class="fa fa-angle-right"></i></a>
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
                            <th>Nom</th>
                            <th class="text-center">Activer</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {if is_array($groupes) AND $groupes|count}
                            {foreach from=$groupes item=groupe}
                                <tr id="{$groupe.id}">
                                    <td class="text-center">{$groupe.id}</td>
                                    <td>{$groupe.nom}</td>
                                    <td class="text-center">
                                        <a id="validate_{$groupe.id}" class="btn btn-{if $groupe.active}success{else}danger{/if}" onclick="toggleActivate('{$groupe.id}');return false;">
                                            <span class="glyphicon glyphicon-{if $groupe.active}ok{else}remove{/if}" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        {if $udroits.edit_2_3 || $udroits.del_2_3 || $currentuserinfos.access_all}
                                            <div class="btn-group-action">
                                                <div class="btn-group">
                                                    <a class="edit btn btn-default {if $udroits.edit_2_3|| $currentuserinfos.access_all}ok{else}disable{/if}" title="Modifier" href="edit-groupe.html?id={$groupe.id}">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                        Modifier
                                                    </a>
                                                    <button class="btn btn-default dropdown-toggle" aria-expanded="false" data-toggle="dropdown" type="button">
                                                        <span class="caret"></span>&nbsp;
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                        {if $udroits.del_2_3 || $currentuserinfos.access_all}
                                                            <li>
                                                                <a href="#" onclick="suppr_entree('groupe', '{$groupe.id}');return false;">
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
                                <td colspan='4'> Aucun enregistrement pour le moment!</td>
                            </tr>
                        {/if}  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

