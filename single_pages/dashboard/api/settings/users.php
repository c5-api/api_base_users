<?php defined('C5_EXECUTE') or die('Access Denied.');
echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper('/users', t('Manage settings for the /users route'), false, false);
	$ih = Loader::helper('concrete/interface');
	$valt = Loader::helper('validation/token');
	$txt = Loader::helper('text');
	echo '<form method="post" action="'.$this->action('save').'">';
	echo '<div class="ccm-pane-body" style="padding-bottom: 0px">';
	foreach($types as $type) { ?>
		<div class="dashboard-icon-list">
			<div class="well">
				<table class="table table-condensed" border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<th colspan="2"><h3><?php echo $txt->unHandle($type)?></h3></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($list[$type] as $handle => $name) { 
							if(in_array($handle, $selected[$type])) {
								$checked = ' checked';
							} else {
								$checked = '';
							}
							?>
							<tr>
			                    <td width="30%"><?php echo $name?></td>
			                    <td width="10%"><input type="checkbox" name="<?php echo $type?>[]" value="<?php echo $handle?>"<?php echo $checked?>/></td>
			                </tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>

	<?php 	
	}
	echo '<div class="clearfix"></div></div>';
	echo '<div class="ccm-pane-footer">';

	echo '<input type="submit" value="'.t('Save').'" class="btn primary"/>';
	echo '</div>';

	echo '</form>';

echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);