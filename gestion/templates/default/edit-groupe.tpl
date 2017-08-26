
<div class="panel">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i> Groupes</h4>
        <p>Edtion d'un groupe utilisateur</p>
    </div>
    <form method="post" class="form-horizontal">
        <div class="panel-body">
            <div class="col-sm-5">
                <div class="form-group">
                    <label for="form_nom" class="col-sm-4 control-label">Nom du groupe <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" required="" name="form_nom" id="form_nom" placeholder="nom" value="{$groupe.nom}" aria-required="true">
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Privilèges du groupe</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row-fluid">
                            {include file="./access-tpl.tpl" elt=$groupe}
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>  
        <div class="panel-footer">
            <div class="row">
                <button type="submit" name="submitGroupe" class="btn btn-success btn-quirk btn-wide mr5">Enregister</button>
                <a class="btn btn-quirk btn-wide btn-default" href="groupes.html">Annuler</a>
            </div>
        </div>
    </form>
</div>


