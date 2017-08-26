<div class="panel panel-danger">
    <ul class="panel-options">
        <li>
            <a class="" href="edit-url.html" title="Ajouter une url">
                    <i class="fa fa-plus"></i>
            </a>
        </li>
    </ul>
    <div class="panel-heading">
        <h4 class="panel-title">Gestion des URL </h4>
    </div>
    <div class="row-">
        <div class="table-responsive">
            <table class="table table-striped nomargin">
                <thead>
                    <tr>
                        <th class="text-align-center">#</th>
                        <th>Page</th>
                        <th>Titre de la page</th>
                        <th>Url Simplifié</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                {foreach from=$urls name=urls item=url}
                <tr>
                        <td class="text-align-center">{$url.id_url}</td>
                        <td>{$url.page}</td>
                        <td>{$url.name}</td>
                        <td>{$url.name|nom_web}</td>
                        <td class="text-right">
                            <div class="btn-group-action">
                                    <div class="btn-group">
                                            <a class="edit btn btn-default" title="Modifier" href="edit-url.html?id={$url.id_url}">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                    Modifier
                                            </a>
                                            <button class="btn btn-default dropdown-toggle" aria-expanded="false" data-toggle="dropdown" type="button">
                                                    <span class="caret"></span>&nbsp;
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                    <li>
                                                            <a href="#" onclick="suppr_entree('url', '{$url.id_url}');return false;">
                                                                    <i class="glyphicon glyphicon-trash"></i>
                                                                    Supprimer
                                                            </a>
                                                    </li>
                                            </ul>
                                    </div>
                            </div>
                                {*<a class="modif" title="Modifier" href="edit-url.html?nom={$url.nom}"></a> <a class="suppr" title="Supprimer" href="liste-urls.html?nom={$url.nom}" onClick="return confirm('Etes vous sûr de vouloir supprimer cette URL?');"></a>*}
                        </td>
                </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>