<table class="table table-striped nomargin">
    <thead>
        <tr>
            <th>#</th>
            <th>
                <label class="ckbox">
                    <input type="checkbox" id="check_all_view">
                    <span> Voir </span>
                </label>
            </th>
            <th>
                <label class="ckbox">
                    <input type="checkbox" id="check_all_add">
                    <span>Ajouter</span>
                </label>
            </th>
            <th>
                <label class="ckbox">
                    <input type="checkbox" id="check_all_edit">
                    <span>Modifier</span>
                </label>
            </th>
            <th>
                <label class="ckbox">
                    <input type="checkbox" id="check_all_del">
                    <span> Supprimer</span>
                </label>
            </th>
        </tr>
    </thead>
    <tbody>
		<tr class="info">
            <td>Site</td>
            <td><input class="check_view" type="checkbox" name="form_access[]" value="view_1"{if $elt.access->view_1} checked{/if}></td>
            <td><input type="checkbox" disabled="" ></td>
            <td><input type="checkbox" disabled="" ></td>
			<td><input type="checkbox" disabled="" ></td>
        </tr>
		<tr>
            <td><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Modifier le logo</td>
            <td><input class="check_view" type="checkbox" name="form_access[]" value="view_1_1"{if $elt.access->view_1_1} checked{/if}></td>
            <td><input type="checkbox" disabled="" ></td>
            <td><input type="checkbox" disabled="" ></td>
			<td><input type="checkbox" disabled="" ></td>
        </tr>
		<tr class="info">
            <td>Utilisateurs</td>
            <td><input class="check_view" type="checkbox" name="form_access[]" value="view_2"{if $elt.access->view_2} checked{/if}></td>
            <td><input type="checkbox" disabled="" ></td>
            <td><input type="checkbox" disabled="" ></td>
			<td><input type="checkbox" disabled="" ></td>
        </tr>
		<tr>
            <td><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Gestionnaires</td>
            <td><input class="check_view" type="checkbox" name="form_access[]" value="view_2_2"{if $elt.access->view_2_2} checked{/if}></td>
            <td><input class="check_add" type="checkbox" name="form_access[]" value="add_2_2"{if $elt.access->add_2_2} checked{/if}></td>
            <td><input class="check_edit" type="checkbox" name="form_access[]" value="edit_2_2"{if $elt.access->edit_2_2} checked{/if}></td>
			<td><input class="check_del" type="checkbox" name="form_access[]" value="del_2_2"{if $elt.access->del_2_2} checked{/if}></td>
        </tr>
		<tr>
            <td><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Groupes</td>
            <td><input class="check_view" type="checkbox" name="form_access[]" value="view_2_3"{if $elt.access->view_2_3} checked{/if}></td>
            <td><input class="check_add" type="checkbox" name="form_access[]" value="add_2_3"{if $elt.access->add_2_3} checked{/if}></td>
            <td><input class="check_edit" type="checkbox" name="form_access[]" value="edit_2_3"{if $elt.access->edit_2_3} checked{/if}></td>
			<td><input class="check_del" type="checkbox" name="form_access[]" value="del_2_3"{if $elt.access->del_2_3} checked{/if}></td>
        </tr>
		
		<tr>
            <td><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Localisation</td>
            <td><input class="check_view" type="checkbox" name="form_access[]" value="view_2_2"{if $elt.access->view_2_2} checked{/if}></td>
            <td><input class="check_add" type="checkbox" name="form_access[]" value="add_2_2"{if $elt.access->add_2_2} checked{/if}></td>
            <td><input class="check_edit" type="checkbox" name="form_access[]" value="edit_2_2"{if $elt.access->edit_2_2} checked{/if}></td>
			<td><input class="check_del" type="checkbox" name="form_access[]" value="del_2_2"{if $elt.access->del_2_2} checked{/if}></td>
        </tr>
		<tr>
            <td><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> URLs et SEO</td>
            <td><input class="check_view" type="checkbox" name="form_access[]" value="view_7_2"{if $elt.access->view_7_1} checked{/if}></td>
            <td><input class="check_add" type="checkbox" name="form_access[]" value="add_7_2"{if $elt.access->add_7_1} checked{/if}></td>
            <td><input class="check_edit" type="checkbox" name="form_access[]" value="edit_7_2"{if $elt.access->edit_7_1} checked{/if}></td>
			<td><input class="check_del" type="checkbox" name="form_access[]" value="del_7_2"{if $elt.access->del_7_1} checked{/if}></td>
        </tr>
		<tr>
            <td><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Traductions</td>
            <td><input class="check_view" type="checkbox" name="form_access[]" value="view_7_3"{if $elt.access->view_7_3} checked{/if}></td>
            <td><input type="checkbox" disabled="" ></td>
            <td><input type="checkbox" disabled="" ></td>
			<td><input type="checkbox" disabled="" ></td>
        </tr>
    </tbody>
</table>
