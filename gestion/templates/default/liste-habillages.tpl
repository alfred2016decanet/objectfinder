<h2 class="titre">Habillages</h2>

<a href="edit-habillage.html"><b>Ajouter un habillage</b></a><br /><br />

{if $habillages}
<table>
<thead>
	<tr>
		<td>Fichier</td>
		<td>Date d&eacute;but</td>
		<td>Date fin</td>
		<td>Modifier</td>
		<td>Supprimer</td>
	</tr>
</thead>
{foreach from=$habillages item=habillage name=habillages}
	<tr id="{$habillage.id}">
		<td>{$habillage.fichier}</td>
		<td>{$habillage.date_debut|date_format:"d/m/Y"}</td>
		<td>{$habillage.date_fin|date_format:"d/m/Y"}</td>
		<td width="50px">
			<a class="modif" title="Modifier" href="edit-habillage.html?id={$habillage.id}"></a>
		</td>
		<td>
			<a style="cursor: pointer;" onclick="suppr_entree('habillage', '{$habillage.id}');return false;" title="Supprimer" class="suppr"></a>
		</td>
	</tr>
{/foreach}
</table>
{/if}