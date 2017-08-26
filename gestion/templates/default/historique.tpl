<h1 class="page-header">
    <span class="glyphicon glyphicon-open-eye" aria-hidden="true"></span> Historique <sup><span class="badge">{$totalHistoque}</span></sup>
</h1>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <form method="post" class="navbar-form navbar-left pager" role="search">
			<div class="form-group">
                <select name="search_administrator" class="form-control">
					<option value=''>Filtrer par gestionaire</option>
					{if is_array($gestionnaires) AND $gestionnaires|count}
						{foreach from=$gestionnaires item=gestionnaire}
							<option value="{$gestionnaire.id}">{$gestionnaire.prenom} {$gestionnaire.nom}</option>
						{/foreach}
					{/if}
				</select>
            </div>
			<div class="form-group">
                <input class="form-control date-pick" value="{if !empty($filters.search_date)}{$filters.search_date}{/if}" name="search_date" type="text" placeholder="à la date du">
            </div>		
            <button class="btn btn-default" name="submitFilter" type="submit">rechercher</button>
        </form>
        {assign var='prevpage' value=$currpage-1}
        {assign var='nextpage' value=$currpage+1}
        <ul class="nav navbar-nav navbar-right pager">
            <li {if $prevpage eq 0}class="disabled"{/if}><a href="{if $prevpage eq 0}#{else}historique.html?p={$prevpage}{/if}" title="Précedent">Précedent</a></li>
            <li class="active" role="presentation">
                <a href="#">{$currpage}/{$nbpages}</a>
            </li>
            <li {if $currpage >= $nbpages}class="disabled"{/if}><a href="{if $currpage >= $nbpages}#{else}historique.html?p={$nextpage}{/if}" title="suivant">Suivant</a></li>
        </ul>
    </div>
</nav>
<div class="row-fluid">
    <div class="panel panel-default">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                   <!-- <th>Auteur</th>-->
				    <th>Admin</th>
					<th>personel</th>
					<th>Action</th>
                    <th>Date et heure</th>
					<th>Adresse IP</th>
                </tr>
            </thead>
            <tbody id="catList">
                {if is_array($historique) AND $historique|count}
                    {foreach from=$historique item=history}
                        <tr id="{$history.id}">
                            <td>{$history.id}</td>
                            <!--<td> {$history.autor_name}</td>-->
							<td>{$history.admin_nom} {$history.admin_prenom}</td>
							<td>{$history.empl_nom} {$history.empl_prenom}</td>
                            <td>{$history.action}</td>
							<td>{$history.dateheure}</td>
							<td>{$history.ip}</td>
                        </tr>
                    {/foreach}   
                {else}
                    <tr>
                        <td colspan="4"> Aucun enregistrement pour le moment!</td>
                    </tr>
                {/if}  
            </tbody>
        </table>
    </div>
</div>

