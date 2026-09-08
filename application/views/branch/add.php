<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="<?=(empty($validation_error) ? 'active' : '') ?>">
				<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> <?=translate('branch_list')?></a>
			</li>
			<li class="<?=(!empty($validation_error) ? 'active' : '') ?>">
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> <?=translate('create_branch')?></a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="list" class="tab-pane <?=(empty($validation_error) ? 'active' : '')?>">
				<div class="mb-md">
					<table class="table table-bordered table-hover table-condensed mb-none table-export">
						<thead>
							<tr>
								<th width="50"><?=translate('sl')?></th>
								<th><?=translate('branch_name')?></th>
								<th><?=translate('school_name')?></th>
								<th><?=translate('email')?></th>
								<th><?=translate('mobile_no')?></th>
								<th><?=translate('state')?></th>
								<th>LGA</th>
								<th>Ward</th>
								<th><?=translate('address')?></th>
								<th class="no-sort"><?=translate('action')?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$count = 1;
								$branchs = $this->db->get('branch')->result();
								foreach($branchs as $row):
							?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo $row->name;?></td>
								<td><?php echo $row->school_name;?></td>
								<td><?php echo $row->email;?></td>
								<td><?php echo $row->mobileno;?></td>
								<td><?php echo $row->state;?></td>
								<td><?php echo $row->lga;?></td>
								<td><?php echo isset($row->ward) ? $row->ward : '';?></td>
								<td><?php echo $row->address;?></td>
								<td class="min-w-c">
								<?php 
								if ($this->app_lib->isExistingAddon('saas')) {
								if (!isEnabledSubscription($row->id)) {
									?>
									<a href="<?=base_url('saas/enabled_school/'.$row->id)?>" class="btn btn-default btn-circle icon" data-toggle="tooltip" data-original-title="<?php echo translate('enable_subscription'); ?>"><i class="fas fa-sitemap"></i></a>
								<?php } } ?>
									<!--update link-->
									<a href="<?=base_url('branch/edit/'.$row->id)?>" class="btn btn-default btn-circle icon">
										<i class="fas fa-pen-nib"></i>
									</a>
									<!-- delete link -->
									<?php echo btn_delete('branch/delete_data/' . $row->id);?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane <?=(!empty($validation_error) ? 'active' : '')?>" id="create">
				<?php echo form_open_multipart($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered validate')); ?>
					<div class="form-group mt-md">
						<label class="col-md-3 control-label"><?=translate('branch_name')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="branch_name" value="<?=set_value('branch_name')?>" />
							<span class="error"><?=form_error('branch_name') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('school_name')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="school_name" value="<?=set_value('school_name')?>" />
							<span class="error"><?=form_error('school_name') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('email')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="email" value="<?=set_value('email')?>" />
							<span class="error"><?=form_error('email') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('mobile_no')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="mobileno" value="<?=set_value('mobileno')?>">
							<span class="error"><?=form_error('mobileno') ?></span>
						</div>
					</div>
					<!-- Currency fields hidden with default NGN -->
					<input type="hidden" name="currency" value="NGN" />
					<input type="hidden" name="currency_symbol" value="₦" />

					<div class="form-group">
						<label class="col-md-3 control-label">Education Board <span class="required">*</span></label>
						<div class="col-md-6">
							<?php
								$ci =& get_instance();
								$ci->load->model('education_board_model');
								$boards = $ci->education_board_model->getBoardDropdown();
							?>
							<select class="form-control" name="board_id" required>
								<?php foreach($boards as $key => $val): ?>
									<option value="<?=$key?>" <?=set_select('board_id', $key)?>><?=$val?></option>
								<?php endforeach; ?>
							</select>
							<span class="error"><?=form_error('board_id')?></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('state')?></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="state" value="Kaduna" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">LGA <span class="required">*</span></label>
						<div class="col-md-6">
							<select class="form-control" name="lga" id="lga_select">
								<option value="">-- Select LGA --</option>
								<?php
								$lgas = array('Birnin Gwari','Chikun','Giwa','Igabi','Ikara','Jaba',"Jema'A",'Kachia','Kaduna North','Kaduna South','Kagarko','Kajuru','Kaura','Kauru','Kubau','Kudan','Lere','Makarfi','Sabon Gari','Sanga','Soba','Zangon Kataf','Zaria');
								foreach($lgas as $lga):
								?>
								<option value="<?=$lga?>" <?=set_value('lga') == $lga ? 'selected' : ''?>><?=$lga?></option>
								<?php endforeach; ?>
							</select>
							<span class="error"><?=form_error('lga') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Ward <span class="required">*</span></label>
						<div class="col-md-6">
							<select class="form-control" name="ward" id="ward_select">
								<option value="">-- Select Ward --</option>
							</select>
							<span class="error"><?=form_error('ward') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label  class="col-md-3 control-label"><?=translate('address')?></label>
						<div class="col-md-6 mb-md">
							<textarea type="text" rows="3" class="form-control" name="address" ><?=set_value('address')?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-3 col-md-3">
							<label class="control-label pt-none"><?=translate('system_logo');?></label>
							<input type="file" name="logo_file" class="dropify dre-render" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage('', 'logo')?>" />
						</div>
						<div class="col-md-3 mb-md">
							<label class="control-label pt-none"><?=translate('text_logo');?></label>
							<input type="file" name="text_logo" class="dropify dre-render" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage('', 'logo-small')?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-3 col-md-3">
							<label class="control-label pt-none"><?=translate('printing_logo');?></label>
							<input type="file" name="print_file" class="dropify dre-render" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage('', 'printing-logo')?>" />
						</div>
						<div class="col-md-3 mb-md">
							<label class="control-label pt-none"><?=translate('report_card');?></label>
							<input type="file" name="report_card" class="dropify dre-render" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage('', 'report-card-logo')?>" />
						</div>
					</div>
					<footer class="panel-footer mt-lg">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
								<button type="submit" class="btn btn-default btn-block" name="submit" value="save">
									<i class="fas fa-plus-circle"></i> <?=translate('save')?>
								</button>
							</div>
						</div>	
					</footer>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</section>


<?php
$lgaWardsData = [
	"Birnin Gwari" => ["Magajin Gari I","Magajin Gari Ii","Magajin Gari Iii","Gayam","Kuyelo","Kazage","Kakangi","Tabanni","Dogon Dawa","Kutemesi","Randagi"],
	"Chikun" => ["Chikun","Gwagwada","Kakau","Kujama","Kunai","Kuriga","Narayi","Nasarawa","Rido","Sabon Tasha","Ung. Yelwa","S/Ggarin Arewa Tirkaniya"],
	"Giwa" => ["Giwa","Kakangi","Gangara","Shika","Danmahawayi","Yakawada","Idasu","Kidandan","Galadimawa","Kadage","Pan Hauya"],
	"Igabi" => ["Turunku","Zangon Aya","Gwaraji","Birnin Yero","Igabi","Rigachikun","Afaka","Sabon Birnin Daji","Kerawa","Kwarau","Gadan Gayan","Rigasa"],
	"Ikara" => ["Ikara","Janfala","K/Kogi","Saulawa","Pala","Saya-Saya","Auchan","Rumi","Paki","Kuya"],
	"Jaba" => ["Nduyah","Sambam","Fada","Sabchem","Sabzuro","Dura/Bitaro","Daddu","Chori","Nok","Fai"],
	"Jema'A" => ["Kafanchan A","Kafanchan B","Maigizo A","Kaninkon","Jagindi","Godogodo","Gidan Waya","Atuku","Asso","Bedde","Kagoma","Takau B"],
	"Kachia" => ["Agunu","Awon","Doka","Gumel","Gidan Tagwai","Kwaturu","Ankwa","Katari","Bishini","Kachia Urban","Sabon Sarki","Kurmin Musa"],
	"Kaduna North" => ["Shaba","Gaji","Unguwan Liman","Maiburji","Kabala Costain/Doki","Gabasawa","Unguwan Sarki","Badarawa","Unguwan Dosa","Kawo","Hayin Banki","Unguwan Shanu"],
	"Kaduna South" => ["Makera","Barnawa","Kakuri Gwari","Television","Kakuri Hausa","Tudun Wada North","Tudun Wada South","Tudun Wada West","Tudun Nuwapa","Sabon Gari South","Sabon Gari North","Ung. Sanusi","Badiko"],
	"Kagarko" => ["Kagarko North","Kagarko South","Kushe","Jere North","Jere South","Iddah","Aribi","Kurmin Jibrin","Katugal","Kukui"],
	"Kajuru" => ["Kajuru","Tantatu","Buda","Kufana","Afogo","Kasuwan Magani","Kallah","Rimau","Idon","Maro"],
	"Kaura" => ["Fada","Kukum","Kpak","Agban","Kadarko","Mallagum","Manchok","Bondon","Kaura","Zankan"],
	"Kauru" => ["Kauru West","Makami","Dawaki","Kwassam","Bital","Geshere","Damakasuwa","Badurum Sama","Kamaru","Pari","Kauru East"],
	"Kubau" => ["Kubau","Dutsen Wai","Pambegua","Zuntu","Damau","Karreh","Anchau","Haskiya","Kargi","Mah","Zabi"],
	"Kudan" => ["Kudan","Hunkuyi","Sabon Gari Hunkuyi","Garu","Zabi","Doka","Likoro","Taban Sani","Kauran Wali North","Kauran Wali South"],
	"Lere" => ["Sabon Birnin","Yar Kasuwa","Garu","Kayarda","Lere","Ramin Kura","Saminaka","Lazuru","Abadawa","Dan Alhaji","Gure/Kahugu"],
	"Makarfi" => ["Makarfi","Tudun Wada","Gazara","Danguziri","Gimi","Nassarawan Doya","Mayere","Gubuchi","Gwanki","Dandamisa"],
	"Sabon Gari" => ["Samaru","Jama'a","Bomo","Basawa","Chikaji","Muchia","Jushin Waje","Hanwa","Dogarawa","Unguwan Gabas","Zabi"],
	"Sanga" => ["Gwantu","Fadan Karshi","Ayu","Ninzam North","Ninzam South","Bokana","Aboro","Ninzam West","Wasa Station","Arak","Nandu"],
	"Soba" => ["Maigana","Kinkiba","Gimba","Kwassallo","Richifa","Gamagira","Dan Wata","Turawa","Soba","Garun Gwanki","Rahama"],
	"Zangon Kataf" => ["Gora","Zonzon","Zaman Dabo","Unguwar Gaiya","Zonkwa","Madakiya","Unguwar Rimi","Gidan Jatau","Kamantan","Kamuru Ikulu North","Zango Urban"],
	"Zaria" => ["Kwarbai A","Kwarbai B","Ung. Juma","Limancin-Kona","Kaura","Tudun Wada","Gyallesu","Ung. Fatika","Tukur Tukur","Dambo","Wucicciri","Dutsen Abba","Kufena"]
];
?>
<script type="text/javascript">
var lgaWards = <?=json_encode($lgaWardsData)?>;

$(document).ready(function() {
	$('#lga_select').on('change', function() {
		var lga = $(this).val();
		var wardSelect = $('#ward_select');
		wardSelect.html('<option value="">-- Select Ward --</option>');
		if (lga && lgaWards[lga]) {
			$.each(lgaWards[lga], function(i, ward) {
				wardSelect.append('<option value="' + ward + '">' + ward + '</option>');
			});
		}
	});

	// Trigger on page load if LGA was pre-selected (validation error)
	var selectedLga = $('#lga_select').val();
	if (selectedLga) {
		$('#lga_select').trigger('change');
		<?php if(set_value('ward')): ?>
		$('#ward_select').val('<?=set_value('ward')?>');
		<?php endif; ?>
	}
});
</script>