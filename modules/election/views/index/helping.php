<div>
	<h1 class="fwbold"><?=t("Допомогти на виборах")?></h1>
</div>

<? $GW = [300, 330] ?>

<div class="mt5">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<h3>Ми йдемо на вибори, щоби змінити країну! Якщо ви хочете допомогти нам у проведенні виборчої кампанії та разом с нами захистити результат виборів — долучайтеся волонтером ВОЛІ як агітатор, член дільничної виборчої комісії або офіційний спостерігач.</h3>
				</td>
				
				<td valign="top" width="<?=$GW[0]?>px">
					<div class="pr30" style="color: #666; box-sizing: border-box">З питань, пов’язаних з виборчою кампанією, звертайтесь до центрального штабу партії:<br /><strong style="white-space: nowrap">0 800 30 78 77</strong><br /><a href="mailto:org.volya@gmail.com">org.volya@gmail.com</a></div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<div class="mt30">
	<table data-ui="switch" cellspacing="0" cellpadding="0" class="fixed_table">
		<tbody>
			<tr>
				
				<td>
					<div>
						<div>
							<a href="javascript:void(0);" data-uiFrame="volunteers"><?=t("Агітатор")?></a>
						</div>
						<div class="mt5">
							<span>Дізнайтеся, як стати агітатором «ВОЛІ» на виборах — і долучайтеся до нас!</span>
						</div>
					</div>
				</td>
				
				<td></td>
				
				<td>
					<div>
						<div>
							<a href="javascript:void(0);" data-uiFrame="members"><?=t("Член дільничної виборчої комісії")?></a>
						</div>
						<div class="mt5">
							<span>Ви можете стати членом дільничної виборчої комісії від партії «ВОЛЯ» — залиште свої контактні дані</span>
						</div>
					</div>
				</td>
				
				<td></td>
				
				<td>
					<div>
						<div>
							<a href="javascript:void(0);" data-uiFrame="observers"><?=t("Спостерігач")?></a>
						</div>
						<div class="mt5">
							<span>Приєднуйтесь до команди офіційних спостерігачів ВОЛІ на виборах!</span>
						</div>
					</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<? include "helping/volunteers.php" ?>
<? include "helping/members.php" ?>
<? include "helping/observers.php" ?>