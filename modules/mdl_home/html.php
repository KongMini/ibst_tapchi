<?php

class View

{

	static function viewhome()

	{

		global $ariacms; 

		global $params;		

		global $database;

		global $ariaConfig_template;

		function text_limit_hotnews($str,$limit=10)

		 {

			 if(stripos($str," ")){

				 $ex_str = explode(" ",$str);

				 if(count($ex_str)>$limit){

				 for($i=0;$i<$limit;$i++){

				 $str_s.=$ex_str[$i]." ";

				 }

				 return $str_s;

				 }else{

				 return $str;

				 }

				 }else{

				 return $str;

			 }

		 }

?>





<!doctype html>

<html lang="en-US">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />



      <?= $ariacms->getBlock("head"); ?>

<body class="home page-template-default page page-id-7 wp-custom-logo" id="page-top">

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-dark-grayscale"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 0.49803921568627" /><feFuncG type="table" tableValues="0 0.49803921568627" /><feFuncB type="table" tableValues="0 0.49803921568627" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-grayscale"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 1" /><feFuncG type="table" tableValues="0 1" /><feFuncB type="table" tableValues="0 1" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-purple-yellow"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.54901960784314 0.98823529411765" /><feFuncG type="table" tableValues="0 1" /><feFuncB type="table" tableValues="0.71764705882353 0.25490196078431" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-blue-red"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 1" /><feFuncG type="table" tableValues="0 0.27843137254902" /><feFuncB type="table" tableValues="0.5921568627451 0.27843137254902" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-midnight"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0 0" /><feFuncG type="table" tableValues="0 0.64705882352941" /><feFuncB type="table" tableValues="0 1" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-magenta-yellow"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.78039215686275 1" /><feFuncG type="table" tableValues="0 0.94901960784314" /><feFuncB type="table" tableValues="0.35294117647059 0.47058823529412" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-purple-green"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.65098039215686 0.40392156862745" /><feFuncG type="table" tableValues="0 1" /><feFuncB type="table" tableValues="0.44705882352941 0.4" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" width="0" height="0" focusable="false" role="none" style="visibility: hidden; position: absolute; left: -9999px; overflow: hidden;" ><defs><filter id="wp-duotone-blue-orange"><feColorMatrix color-interpolation-filters="sRGB" type="matrix" values=" .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 .299 .587 .114 0 0 " /><feComponentTransfer color-interpolation-filters="sRGB" ><feFuncR type="table" tableValues="0.098039215686275 1" /><feFuncG type="table" tableValues="0 0.66274509803922" /><feFuncB type="table" tableValues="0.84705882352941 0.41960784313725" /><feFuncA type="table" tableValues="1 1" /></feComponentTransfer><feComposite in2="SourceGraphic" operator="in" /></filter></defs></svg>



	<?= $ariacms->getBlock("header"); ?>

	<?= $ariacms->getBlock("underheader"); ?>	
		
		
		<style>
			.stripe-bg{
				background-color: #d7d7d7d6;
				background-image: url(data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 4 4'%3E%3Cpath fill='%23959ca1' fill-opacity='0.4' d='M1 3h1v1H1V3zm2-2h1v1H3V1z'%3E%3C/path%3E%3C/svg%3E);
			}

		</style>
		
		<div class="border-top main-content home-office-sizes-section stripe-bg">
		
		<div class="row">
			<div class="container" style="width: 91%">
				<div class="twelve columns">
                    <div class="heading-container" style="font-size:20px">
                        <div onclick="tab('nhieunhat', 'moinhat')" id="nhieunhat" style="     position: relative;;margin-right: -10px;color:#fff; cursor:pointer;float: left;background-color: rgb(159 87 28);padding: 0px 10px;border-radius: 0 12px 0 0;width: 300px"><?= _MOST_READ_ARTICLES?></div>
                        <div onclick="tab('moinhat', 'nhieunhat')" style="cursor:pointer;color:#0044ff;float: left;background-color: rgb(210 165 128);padding: 0px 10px;border-radius: 0 12px 0 0;width: 300px;text-align: center;" id="moinhat"><?= _LASTEST_ARTICLES?></div>
                    </div>
				</div>
			</div>
		</div>
		<?php

        $query = "SELECT * FROM `e4_tapchi`  WHERE type = 'tapchi' ORDER BY visited_count DESC limit 0,3";
        $database->setQuery($query);
        $newsnhieunhat = $database->loadObjectList();

        $query = "SELECT * FROM `e4_tapchi`  WHERE type = 'tapchi' ORDER BY id DESC limit 0,3";
        $database->setQuery($query);
        $newsmoinhat = $database->loadObjectList();

        ?>
		<div class="row" id="tabnhieunhat">
			<div class="flex-container max-width center-on-mobile" style="margin-top: -5px;">
                <?php foreach ($newsnhieunhat as $new){?>
                <div class="flex-col-3">
						<div class="firm-type-container">
                            <h3 class="home-office-sizes-section">
                                <a href="<?= $ariacms->actual_link ?>chi-tiet/<?= $new->url_part ?>.html"><?= $ariacms->textLimit($new -> {$params -> title}, 100)?></a>
                            </h3>
							<?= $ariacms->textLimit(str_replace('<strong>', '', str_replace('</strong>', '', $new -> {$params -> tacgia})), 16)?>
							
                            <p class="button-container">
                                <a href="<?= $ariacms->actual_link ?>chi-tiet/<?= $new->url_part ?>.html"><i class="fas fa-eye" style="font-size:16px" aria-hidden="true"></i> <?= $new->visited_count ?></a>
                            </p>
						</div>
				</div>
                <?php }?>
			</div>
        </div>
        <div class="row" id="tabmoinhat" style="display:none">
			<div class="flex-container max-width center-on-mobile" style="margin-top: -5px;">
                <?php foreach ($newsmoinhat as $new){?>
                    <div class="flex-col-3">
                        <div class="firm-type-container">
                            <h3 class="home-office-sizes-section">
                                <a href="<?= $ariacms->actual_link ?>chi-tiet/<?= $new->url_part ?>.html"><?= $ariacms->textLimit($new -> {$params -> title}, 100) ?></a>
                            </h3>
                            <?= $ariacms->textLimit(str_replace('<strong>', '', str_replace('<strong>', '', $new -> {$params -> tacgia})), 16)?>
                            <p class="button-container" style='min-height:6px'>
                                <a href="<?= $ariacms->actual_link ?>chi-tiet/<?= $new->url_part ?>.html"><i class="fas fa-eye" style="font-size:16px" aria-hidden="true"></i> <?= $new->visited_count ?></a>
                            </p>
                        </div>
                    </div>
                <?php }?>
				<style>
					.home-office-sizes-section p{
						min-height: 30px;
					}
				</style>
			</div>
		</div>

		<script>
			function tab(id, id_hidden){
                // active
				document.getElementById(id).style.color = '#fff';
                document.getElementById(id).style.backgroundColor = 'rgb(159 87 28)';

                // deactive
				document.getElementById(id_hidden).style.color = '#0044ff';
                document.getElementById(id_hidden).style.backgroundColor = 'rgb(210 165 128)';

                // tab
				document.getElementById('tab'+ id).style.display = 'block';
				document.getElementById('tab' + id_hidden).style.display = 'none';
			}
		</script>
	</div>


	
	<?= $ariacms->getBlock("footer"); ?>

	<?= $ariacms->getBlock("footer_script"); ?>

	 </body>

	</html>







<?php

	}

}



?>