<h1 class="page-header">
    Localisation
</h1>

<form method="post" class="form-horizontal">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="glyphicon glyphicon-cog"></i> Paramètres</h3>
		</div>
		<div class="panel-body">
			<div class="row-fluid">
				<div class="form-group">
					<label for="form_id_category" class="col-sm-2 control-label">Module Actualités</label>
					<div class="col-sm-3">
						<select name="mod_actu" class="form-control">
							<option value="">---</option>
							{include file='./category_option.tpl' defcat=$configs.mod_actu}
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<button type="submit" name="submitModules" class="btn btn-primary">
				<i class="glyphicon glyphicon-save"></i>
				Enregister
			</button>
		</div>
	</div>
</form>