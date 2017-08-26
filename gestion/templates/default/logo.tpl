<h1 class="titre">LOGO</h1>
<form method="post" enctype="multipart/form-data">
    <div class="section">
        <table class="tab-edit">
			 <tr id="image_container">
                <td>
					{if !empty($s_config.usr.logo)}
						<img src="{$URL_BASE}data/img/logo/{$s_config.usr.logo}" alt="logo" />
				   {/if}
				</td>
             </tr>
            <tr>
                {if $udroits.add_2_2 || $currentuserinfos.access_all}
                        <a class="btn btn-success" href="edit-medias.html?ftarget=logo">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                Changer
                        </a>
                {/if}
            </tr>
           
        </table>
    </div>
</form>
