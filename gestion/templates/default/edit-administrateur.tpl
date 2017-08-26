{if !$admin.membre_id}<h1 class="titre">Ajout d'un administrateur</h1>
{else}<h1 class="titre">Modification d'un administrateur</h1>{/if}

<form action="edit-administrateur.html{if $admin.membre_id}?id={$admin.membre_id}{/if}" method="POST" enctype="multipart/form-data">
	
	<div id="gestion">
		<div class="onglet" id="contenu">
			<table class="tab-edit">
				<tr>
					<td>
						<label for="pseudo">Identifiant :</label><br />
						<input type="text" id="pseudo" name="membre_identifiant" size="50" value="{$admin.membre_identifiant}"/><br/><br/>
					</td>
				</tr>
				<tr>
					<td>
						<label for="pass">{if $admin->id}Nouveau p{else}P{/if}ass :</label><br />
						<input type="password" id="pass" name="pass" size="30"/><br/><br/>
					</td>
				</tr>
				<tr>
					<td id="kms_admin_droits"><!-- Ne pas changer cet id car il est utilisé dans la gestion des droits coté KmsUser -->
						<label for="droits">Droits :</label><br />
						<fieldset id="droits">
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="1_0"{if $admin.droits.1_0} checked{/if}> 
							<label>Accueil</label>
						</div><hr/>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="3_0"{if $admin.droits.3_0} checked{/if}> 
							<label>Actualités</label>
						</div><hr/>
                        <div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="17_0"{if $admin.droits.17_0} checked{/if}> 
							<label>Commandes</label>
						</div><hr/>
                      	<strong>Site :</strong>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="2_0"{if $admin.droits.2_0} checked{/if}>
							<label>CMS</label>
						</div>
                        <div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="2_3"{if $admin.droits.2_3} checked{/if}> 
							<label>Encarts publicitaires</label>
						</div>
                        <div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="2_1"{if $admin.droits.2_1} checked{/if}>
							<label>Habillages</label>
						</div>
                        <div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="2_2"{if $admin.droits.2_2} checked{/if}>
							<label>Modification du logo</label>
						</div>
                        
                        <div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="2_4"{if $admin.droits.2_4} checked{/if}> 
							<label>Sliders</label>
						</div><hr/>
						
						
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="4_0"{if $admin.droits.4_0} checked{/if}> 
							<label>Utilisateur KMS</label>
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="5_0"{if $admin.droits.5_0} checked{/if}> 
							<label>Courses</label>
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="6_0"{if $admin.droits.6_0} checked{/if}> 
							<label>Inscriptions</label>
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="7_0"{if $admin.droits.7_0} checked{/if}> 
							<label>Boutiques</label>
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="8_0"{if $admin.droits.8_0} checked{/if}> 
							<label>R&eacute;sultats</label>
						</div><hr/>
						
						<strong>Stats/SEO :</strong>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="12_0"{if $admin.droits.12_0} checked{/if}> <label>Référencement </label>
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="12_1"{if $admin.droits.12_1} checked{/if}> <label>URLs </label>
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="12_2"{if $admin.droits.12_2} checked{/if}> <label>Infos utilisateurs </label>
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="12_3"{if $admin.droits.12_3} checked{/if}> <label>Statistiques</label>
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="13_0"{if $admin.droits.13_0} checked{/if}> <label>Gérer les administrateurs</label>
						</div><hr/>
						<strong>Bons de réduction :</strong>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="18_0"{if $admin.droits.18_0} checked{/if}> <label>Bons de réduction</label> 
						</div><hr/>
						<strong>Réglages :</strong>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="14_0"{if $admin.droits.14_0} checked{/if}> <label>Performances</label> 
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="14_1"{if $admin.droits.14_1} checked{/if}> <label>Maintenance</label>
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="14_2"{if $admin.droits.14_2} checked{/if}> <label>Sécurité</label>
						</div>
						<div class="kmsuser_control_field">
							<input type="checkbox" name="droits[]" value="14_3"{if $admin.droits.14_3} checked{/if}> <label>Mises à jour</label>
						</div>
                        </fieldset>
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

