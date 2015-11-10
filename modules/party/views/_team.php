<? include "common/header.php" ?>

<div class="section mt30">
	<div>
		<h3 class="fwbold fs25" style="color: #858383"><?=t("Команда")?></h3>
	</div>
	
	<div class="mt30">
		
		<?php foreach($list as $member){ ?>
			<?php
				list($d, $m, $y) = explode(".", $member["age"]);
				
				if($m > date('m') || $m == date('m') && $d > date('d'))
					$age = date('Y') - $y - 1;
				else
					$age = date('Y') - $y;
				
				$age = (string) $age;
				
				if( $age[strlen($age) - 1] == 1 && $age > 11 )
					$age .= " рік";
				elseif( $age[strlen($age) - 1] >= 2 && $age[strlen($age) - 1] <= 4 )
					$age .= " роки";
				elseif( $age[strlen($age) - 1] >= 5 && $age[strlen($age) - 1] <= 9 || $age[strlen($age) - 1] == 0 )
					$age .= " років";

				$__bio = explode(' ', $member["bio"][Router::getLang()] );
				$__bioDescrArr = array_slice( $__bio, 0, 90 );
				$__bioDescr = implode(' ', $__bioDescrArr );
				$__hideDescrButton = false;
				
				$__bioFullArr = array_slice( $__bio, 90 );
				$__bioFull = implode(' ', $__bioFullArr );
				
				if((count($__bioFullArr)+count($__bioDescrArr)) >= 90)
					$__bioDescr .= "<span id='ellipsis'>...</span>";
				else
					$__hideDescrButton = true;
			?>
			<div class="team-member">
				<div class="member-avatar fleft" style="background-image: url('/s/img/thumb/ak/<?=$member["photo"]?>');"></div>
				
				<div class="member-content fleft">
					<div class="member-name fs32"><?=$member["name"][Router::getLang()]?></div>
					<div class="member-info">
						<p class="fs18 job mt10"><?=$age.', '.$member["job"][Router::getLang()]?></p>
						<p class="slogan mt5"><?=$member["slogan"][Router::getLang()]?></p>
						
						<section class="bio p10">
							<?=$__bioDescr?>
							<?if( ! $__hideDescrButton){?>
								<div class="full_bio dnone"><?=$__bioFull?></div>
							<?}?>
						</section>
						
						<section class="links fleft">
							<ul>
								<?php foreach ($member["links"] as $link){ ?>
									<?php 
										$link_name = parse_url($link);
										$link_name = $link_name['host'];
									?>
									<li><a href="<?=$link?>"><?=$link_name?></a></li>
								<?}?>
							</ul>
						</section>
						<?if( ! $__hideDescrButton){?>
							<button class="member-detail expand fright mt15 p10 fs14">
								<img src="/img/frontend/team/details_arrow.png" />
								<?=t("Детальніше")?>
							</button>
						<?}?>
					</div>
				</div>
			</div>
			<div class="cboth"></div>
			
		<? } ?>
		
	</div>
	
</div>