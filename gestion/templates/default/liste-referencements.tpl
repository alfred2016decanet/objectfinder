<h1 class="titre" id="accueil-titre">Référencement</h1>

<br/>
<a href="edit-referencement.html">Ajouter une page</a><br/>
<br/>

<table class="table table-striped nomargin">
	<thead>
		<tr>
			<td>Page</td>
			<td>Modifier</td>
		</tr>
	</thead>
	
	{foreach from=$referencements name=referencements item=ref}
	<tr>
		<td>{$ref.page}</td>
		<td width="50px">
			<a class="modif" title="Modifier" href="edit-referencement.html?id={$ref.id}"></a> <a class="suppr" title="Supprimer" href="liste-referencements.html?id={$ref.id}" onClick="return confirm('Etes vous sûr de vouloir supprimer le référencement de cette page?');"></a>
		</td>
	</tr>
	{/foreach}
</table>