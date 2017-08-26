
<div class="row">
    <div class="col-md-12">
        <form action="#" class="form-horizontal" method="POST" id="data_db_crud">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Genérateur de crud 
                    </h4>
                </div>
                <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">page listes</label>
                            <div class="col-sm-4">
                                <input type="text" name="page_des_liste" id="page_des_liste" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">page édition</label>
                            <div class="col-sm-4">
                                <input type="text" name="page_edition" id="page_edition" class="form-control"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Titre</label>
                            <div class="col-sm-4">
                                <input type="text" name="Titre" id="Titre" class="form-control"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-4">
                                <input type="text" name="Description" id="Description" class="form-control"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nombres d'élements à afficher</label>
                            <div class="col-sm-2">
                                <select id="show_pagination" name="show_pagination" class="form-control" style="width: 50%">
                                        <option value=""></option>
                                        <option value="0">Tout Afficher</option>
                                        <option value="20" selected>20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nom des tables en base de donnée:&nbsp;</label>
                            <div class="col-sm-5">
                                <select id="table-name" name="table_name" class="form-control" style="width: 50%">
                                    <option value=""></option>
                                    {foreach from=$entities item=t}
                                        <option value="{$t.Tables_in_framework_db}">{$t.Tables_in_framework_db}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    <div class="form-group">
                       <div class="table-responsive" id="table_attribute"></div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-2">
                            <button class="btn btn-primary" id="submitTablecrud" name="submitTablecrud" type="submit">
                                <i class="glyphicon glyphicon-save"></i>
                                Enregister
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- panel -->
        </form>
    </div><!-- col-md-6 -->
</div><!-- row -->