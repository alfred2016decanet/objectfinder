
<div class="row-fluid">
    <div id="fieldset_0" class="panel panel-danger">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="glyphicon glyphicon-globe"></i>Langues</h4>
            <p> Edtion d'une langue</p>
        </div>
        <form method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="panel-body">
                <div class="form-group">
                        <label for="form_name" class="col-sm-3 control-label">Nom <sup>*</sup></label>
                        <div class="col-sm-9">
                                <input type="text" required="" class="form-control" name="form_name" id="form_nom" placeholder="nom" value="{$langue.name}">
                        </div>
                </div>
                <div class="form-group">
                        <label for="form_iso_code" class="col-sm-3 control-label">Code ISO <sup>*</sup></label>
                        <div class="col-sm-9">
                                <input type="text" required="" class="form-control" name="form_iso_code" id="form_iso_code" placeholder="Code ISO" value="{$langue.iso_code}">
                        </div>
                </div>
                <div class="form-group">
                        <label for="form_language_code" class="col-sm-3 control-label">Code de langue <sup>*</sup></label>
                        <div class="col-sm-9">
                                <input type="text" required="" class="form-control" name="form_language_code" id="form_language_code" placeholder="Code de langue" value="{$langue.language_code}">
                        </div>
                </div>
                <div class="form-group">
                        <label for="form_date_format_lite" class="col-sm-3 control-label">Format de date  <sup>*</sup></label>
                        <div class="col-sm-9">
                                <input type="text" required="" class="form-control" name="form_date_format_lite" id="form_date_format_lite" placeholder="Format de date " value="{$langue.date_format_lite}">
                        </div>
                </div>
                <div class="form-group">
                        <label for="form_date_format_full" class="col-sm-3 control-label">Format de date (complet)  <sup>*</sup></label>
                        <div class="col-sm-9">
                                <input type="text" required="" class="form-control" name="form_date_format_full" id="form_date_format_full" placeholder="Format de date (complet) " value="{$langue.date_format_full}">
                        </div>
                </div>
                {if $langue.drapeau != ''}
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <img id="img-thumbnail" src="{$langue.drapeau}" class="img-responsive img-thumbnail" alt="Responsive image">
                    </div>
                </div>
                {/if}
                <div class="form-group">
                        <label for="drapeau" class="col-sm-3 control-label">Drapeau</label>
                        <div class="col-sm-9">
                            <input id="drapeau" name="drapeau" type="file">
                        </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                     <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" name="submitLangue" class="btn btn-primary">Enregister</button>
                        <a class="btn btn-default" href="langues.html">Annuler</a>
                     </div>
                </div>
                
            </div>
	</form> 
        </div>
</div>


