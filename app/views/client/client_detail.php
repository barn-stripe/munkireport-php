<?php $this->view('partials/head') ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<?php $this->view('client/machine_info'); ?>

<?php 

// Tab list, each item should contain: 
//	'view' => path/to/tab
// 'i18n' => string representing a localised name
// Optionally:
// 'view_vars' => array with variables to pass to the vies
// 'badge' => id of a badge for this tab
// 'class' => signify first active tab
$tab_list = array(
	'munki' => array('view' => 'client/munki_tab', 'i18n' => 'client.tab.munki', 'class' => 'active'),
	'apple-software' => array('view' => 'client/install_history_tab', 'view_vars' => array('apple'=> 1), 'i18n' => 'client.tab.apple_software', 'badge' => 'history-cnt-1'),
	'third-party-software' => array('view' => 'client/install_history_tab', 'view_vars' => array('apple'=> 0), 'i18n' => 'client.tab.third_party_software', 'badge' => 'history-cnt-0'),
	'inventory-items' => array('view' => 'client/inventory_items_tab', 'i18n' => 'client.tab.inventory_items', 'badge' => 'inventory-cnt'),
	'network-tab' => array('view' => 'client/network_tab', 'i18n' => 'client.tab.network', 'badge' => 'network-cnt'),
	'directory-tab' => array('view' => 'client/directory_tab', 'i18n' => 'client.tab.ds', 'badge' => 'directory-cnt'),
	'displays-tab' => array('view' => 'client/displays_tab', 'i18n' => 'client.tab.displays', 'badge' => 'displays-cnt'),
	'filevault-tab' => array('view' => 'client/filevault_tab', 'i18n' => 'client.tab.fv_escrow'),
	'bluetooth-tab' => array('view' => 'client/bluetooth_tab', 'i18n' => 'client.tab.bluetooth'),
	'power-tab' => array('view' => 'client/power_tab', 'i18n' => 'client.tab.power'),
	'profile-tab' => array('view' => 'client/profile_tab', 'i18n' => 'client.tab.profiles'),
	'ard-tab' => array('view' => 'client/ard_tab', 'i18n' => 'client.tab.ard')
		)
?>

			<ul class="nav nav-tabs">

			<?foreach($tab_list as $name => $data):?>

				<li <?if(isset($data['class'])):?>class="active"<?endif?>>
					<a href="#<?php echo $name?>" data-toggle="tab"><span data-i18n="<?php echo $data['i18n']?>"></span>
					<?php if(isset($data['badge'])):?> 
					 <span id="<?php echo $data['badge']?>" class="badge">0</span>
					<?php endif?>
					</a>
				</li>

			<?endforeach?>

			</ul>

			<div class="tab-content">

			<?foreach($tab_list as $name => $data):?>

				<div class="tab-pane <?if(isset($data['class'])):?>active<?endif?>" id='<?php echo $name?>'>
					<?php $this->view($data['view'], isset($data['view_vars'])?$data['view_vars']:array());?>
				</div>

			<?endforeach?>

			</div>

			<script src="<?php echo conf('subdirectory'); ?>assets/js/bootstrap-tabdrop.js"></script>

			<script>
			$(document).on('appReady', function(e, lang) {

				// Format OS Version
				$('span.osvers').html(integer_to_version($('span.osvers').html()))

				// Activate tabdrop
				$('.nav-tabs').tabdrop();

				// Activate correct tab depending on hash
				var hash = window.location.hash.slice(5);
				$('.nav-tabs a[href="#'+hash+'"]').tab('show');

				// Update hash when changing tab
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var url = String(e.target)
					if(url.indexOf("#") != -1)
					{
						var hash = url.substring(url.indexOf("#"));
						// Save scroll position
						var yScroll=document.body.scrollTop;
						window.location.hash = '#tab_'+hash.slice(1);
						document.body.scrollTop=yScroll;
					}
				})

				// Set times
				$( "dd time" ).each(function( index ) {
					if($(this).hasClass('absolutetime'))
					{
						seconds = moment().seconds(parseInt($(this).attr('datetime')))
						$(this).html(moment(seconds).fromNow(true));
					}
					else
					{
						$(this).html(moment($(this).attr('datetime') * 1000).fromNow());
					}
					$(this).tooltip().css('cursor', 'pointer');
				});
			});
			</script>
	    </div> <!-- /span 12 -->
	</div> <!-- /row -->
</div>  <!-- /container -->

<?php $this->view('partials/foot'); ?>
