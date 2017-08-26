{* é *}
{if !$excel}
<h2 class="titre">Administrateurs</h2>
<a href="edit-administrateur.html">Ajouter un administrateur</a><br><br>
<table>
	<thead>
		<td>Login</td>
		<td></td>
		<td></td>
	</thead>
	{foreach from=$admins item=admin name=admins}
	<tr>
		<td>{$admin.membre_identifiant}</td>
		<td><a href="edit-administrateur.html?id={$admin.membre_id}">Voir</a></td>
		<td><a href="liste-administrateurs.html?del={$admin.membre_id}" onClick="return confirm('Voulez vous vraiment supprimer ce compte?');">Supprimer</a></td>
	</tr>
	{/foreach}
</table>

{else}membre_id;membre_email;membre_civ;membre_naissance;membre_pays;membre_inscription;membre_connexion;newsletter
{foreach from=$users item=user name=users}
{$user.membre_id};{$user.membre_email};{$user.membre_civ};{$user.membre_naissance};{$user.membre_pays};{$user.membre_inscription};{$user.membre_connexion};{$user.newsletter}
{/foreach}
{/if}