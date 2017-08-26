
<div class="panel panel-danger">
    <ul class="panel-options">
        {if $udroits.add_2_2 || $currentuserinfos.access_all}
            <li>
                <a class="" href="edit-langue.html" title="Ajouter une nouvelle langue">
                    <i class="fa fa-plus"></i>
                </a>
            </li>
        {/if}
    </ul>
    <div class="panel-heading">
        <h4 class="panel-title"><i class="glyphicon glyphicon-cog"></i> Langues</h4>
        <p>Gerer vos  Langues</p>
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
                <a class="btn btn-default" href="{if $prevpage eq 0}#{else}langues.html?p={$prevpage}{/if}" title="Précedent"><i class="fa fa-angle-left"></i></a>
                <a class="btn btn-default"  href="#">{$currpage}/{$nbpages}</a>
                <a class="btn btn-default"  href="{if $currpage >= $nbpages}#{else}langues.html?p={$nextpage}{/if}" title="suivant"><i class="fa fa-angle-right"></i></a>
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
                            <th class="text-align-center">#</th>
                            <th class="text-align-center">Drapeau</th>
                            <th>Nom</th>
                            <th class="text-align-center">Code ISO</th>
                            <th class="text-align-center">Code de la langue</th>
                                                <th class="text-align-center">Format de date</th>
                                                <th class="text-align-center">Format de date (complet)</th>
                            <th class="text-align-center">Activer</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {if is_array($langues) AND $langues|count}
                            {foreach from=$langues item=langue}
                                <tr id="{$langue.id_lang}">
                                    <td class="text-center">{$langue.id_lang}</td>
                                    <td class="text-center"> <img src="{$langue.drapeau}" class="img-thumbnail" alt="Responsive image"></td>
                                    <td class="">{$langue.name}</td>
                                    <td class="text-center">{$langue.iso_code}</td>
                                    <td class="text-center">{$langue.language_code}</td>
                                                                <td class="text-center">{$langue.date_format_lite}</td>
                                                                <td class="text-center">{$langue.date_format_full}</td>
                                    <td class="text-center">
                                        <a id="validate_{$langue.id_lang}" class="btn btn-{if $langue.active}success{else}danger{/if}" onclick="genericToggleActivate('{$langue.id_lang}', 'langues.html');return false;">
                                            <span class="glyphicon glyphicon-{if $langue.active}ok{else}remove{/if}" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        {if $udroits.edit_7_2 || $udroits.del_7_2 || $currentuserinfos.access_all}
                                            <div class="btn-group-action" >
                                                <div class="btn-group clearfix">
                                                    <a class="edit btn btn-default {if $udroits.edit_7_2 || $currentuserinfos.access_all}ok{else}disable{/if}" title="Modifier" href="edit-langue.html?id={$langue.id_lang}">
                                                            <i class="glyphicon glyphicon-pencil"></i>
                                                            Modifier
                                                    </a>
                                                    <button class="btn btn-default dropdown-toggle" aria-expanded="false" data-toggle="dropdown" type="button">
                                                            <span class="caret"></span>&nbsp;
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                        {*{if $udroits.edit_7_2 || $currentuserinfos.access_all}
                                                        <li><a href="edit-langue.html?id={$langue.id}">Modifier</a></li>
                                                        {/if}*}
                                                        {if $udroits.del_7_2 || $currentuserinfos.access_all}
                                                                <li>
                                                                        <a href="#" onclick="suppr_entree('langue', '{$langue.id_lang}');return false;">
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
