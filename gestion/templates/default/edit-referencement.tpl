{if !$referencement.referencement_id}<h1 class="titre">Ajout d'une page</h1>
{else}<h1 class="titre">Modification du référencement de la page {$referencement.referencement_page}</h1>{/if}

<form action="edit-referencement.html{if $referencement.id}?id={$referencement.id}{/if}" method="POST">
	
	<div id="gestion">
		<div class="onglet" id="contenu">
			<table class="tab-edit">
				<tr>
					<td>
						<label for="nom">Nom de la page :</label><br />
						<input type="text" id="nom" name="form_referencement_page" size="50" value="{$referencement.page}"/><br/><br/>
					</td>
				</tr>
				<tr>
					<td>
						<label for="nom">URL :</label><br />
						<input type="text" id="nom" {if $referencement.referencement_statut eq '1'}readonly="readonly"{/if} name="form_referencement_url" value="{$referencement.url}" size="50"/><br/><br/>
					</td>
				</tr>
				<tr>
					<td>
						<label for="nom">Titre :</label><br />
						<textarea id="nom" name="form_referencement_titre" cols="80" rows="3">{$referencement.titre}</textarea><br/><br/>
					</td>
				</tr>
				<tr>
					<td>
						<label for="nom">Description :</label><br />
						<textarea id="nom" name="form_referencement_description" cols="80" rows="5">{$referencement.description}</textarea>
					</td>
				</tr>
				<tr>
					<td>
						<label for="nom">Mots clés :</label><br />
						<textarea id="nom" name="form_referencement_motsCles" cols="80" rows="5">{$referencement.mots_cles}</textarea>
					</td>
				</tr>
			</table>
		</div>
	</div>

	
	<br />
	{if $url_back}<input type="hidden" value="{$url_back}" name="url_back" />{/if}
	<input type="submit" id="submit" value="Enregistrer" name="Enregistrer" />
	<a href="{$url_back}">Annuler</a>
</form>

