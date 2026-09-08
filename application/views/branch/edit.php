<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li>
				<a href="<?=base_url('branch')?>"><i class="fas fa-list-ul"></i> <?=translate('branch_list')?></a>
			</li>
			<li class="active">
				<a href="#edit" data-toggle="tab"><i class="far fa-edit"></i> <?=translate('edit_branch')?></a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="edit">
				<?php echo form_open_multipart($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered validate')); ?>
					<input type="hidden" name="branch_id" id="branch_id" value="<?php echo $data->id; ?>">
					<div class="form-group mt-md">
						<label class="col-md-3 control-label"><?=translate('branch_name')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="branch_name" value="<?=set_value('branch_name', $data->name)?>" />
							<span class="error"><?=form_error('branch_name') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('school_name')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="school_name" value="<?=set_value('school_name', $data->school_name)?>" />
							<span class="error"><?=form_error('school_name') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('email')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="email" value="<?=set_value('email', $data->email)?>"  />
							<span class="error"><?=form_error('email') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('mobile_no')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="mobileno" value="<?=set_value('mobileno', $data->mobileno)?>" />
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
								$this->load->model('education_board_model');
								$boards = $this->education_board_model->getBoardDropdown();
							?>
							<select class="form-control" name="board_id" required>
								<?php foreach($boards as $key => $val): ?>
									<option value="<?=$key?>" <?php if(isset($data->board_id) && $data->board_id == $key) echo 'selected'; ?>><?=$val?></option>
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
								$currentLga = set_value('lga', $data->lga);
								foreach($lgas as $lga):
								?>
								<option value="<?=$lga?>" <?=$currentLga == $lga ? 'selected' : ''?>><?=$lga?></option>
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
						<div class="col-md-6">
							<textarea type="text" rows="3" class="form-control" name="address" ><?=set_value('address', $data->address)?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-3 col-md-3">
							<label class="control-label pt-none"><?=translate('system_logo');?></label>
							<input type="file" name="logo_file" class="dropify dre-render" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage($data->id, 'logo')?>" />
						</div>
						<div class="col-md-3 mb-md">
							<label class="control-label pt-none"><?=translate('text_logo');?></label>
							<input type="file" name="text_logo" class="dropify dre-render" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage($data->id, 'logo-small')?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-3 col-md-3">
							<label class="control-label pt-none"><?=translate('printing_logo');?></label>
							<input type="file" name="print_file" class="dropify dre-render" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage($data->id, 'printing-logo')?>" />
						</div>
						<div class="col-md-3 mb-md">
							<label class="control-label pt-none"><?=translate('report_card');?></label>
							<input type="file" name="report_card" class="dropify dre-render" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage($data->id, 'report-card-logo')?>" />
						</div>
					</div>
					<footer class="panel-footer mt-lg">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
								<button type="submit" class="btn btn-default btn-block" name="submit" value="save">
									<i class="fas fa-plus-circle"></i> <?=translate('update')?>
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

	// Pre-select ward on page load for edit form
	var selectedLga = $('#lga_select').val();
	if (selectedLga) {
		$('#lga_select').trigger('change');
		var savedWard = '<?=isset($data->ward) ? addslashes($data->ward) : ''?>';
		if (savedWard) {
			$('#ward_select').val(savedWard);
		}
	}
});
</script>