<?php
$leadType = isset($_GET['lead_type']) ? strtolower($_GET['lead_type']) : '';
$resetIcon = true;
if ($leadType === 'verified') {
    $pageTitle = "Verified Leads";
} elseif ($leadType === 'qualified') {
    $pageTitle = "Qualified Leads";
} else {
    $pageTitle = "All Leads";
	$resetIcon = false;
}
?>
<div class="page-content-inner lead-page">
	<div class="visibility_main" style="display: none;">
		<div class="outer_main"></div>
		<div class="outer">
			<div id='basic' class='well inner' style="height:auto;width:500px"></div>
		</div>
	</div>
	<div class="filter-popup" id="filterBox" style="display:none;">
		<div class="filter-popup-overlay"></div>
		<div class="filter-popup-body">
			<div class="filter-popup-header">
				<h3>Filters</h3>
				<div class="close-icon" id="close_popup">
					<img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_close_i.svg">
				</div>
			</div>
			<div class="filter-form">
				<div class="filter-field date-field">
					<label>Date Range :</label>
					<div class="input-with-icon">
					<input type="text" id="filter_daterange" placeholder="Please select" autocomplete="off" />
					<i class="fa fa-calendar" aria-hidden="true"></i>
					</div>
				</div>

				<div class="filter-field">
					<label>Select Category :</label>
					<div class="select-with-icon">
					<select id="filter_category" class="multiselect" multiple>
						<?php foreach ($category_list as $cat_id => $cat_name) { ?>
						<option value="<?= $cat_id ?>"><?= $cat_name ?></option>
						<?php } ?>
					</select>
					<i class="fa fa-caret-down" aria-hidden="true"></i>
					</div>
				</div>

				<div class="filter-field">
					<label>Select Country :</label>
					<div class="select-with-icon">
					<select id="filter_country" class="multiselect" multiple>
						<?php foreach ($lead_country_list as $country_name) { ?>
						<option value="<?= $country_name ?>"><?= $country_name ?></option>
						<?php } ?>
					</select>
					<i class="fa fa-caret-down" aria-hidden="true"></i>
					</div>
				</div>

				<div class="filter-field">
					<label>Select Status :</label>
					<div class="select-with-icon">
					<select id="filter_status" class="multiselect" multiple>
						<?php foreach ($lead_status_list as $status_name) { ?>
						<option value="<?= $status_name ?>"><?= $status_name ?></option>
						<?php } ?>
					</select>
					<i class="fa fa-caret-down" aria-hidden="true"></i>
					</div>
				</div>

				<div class="filter-btns">
					<button id="resetFilter" class="btn btn-default">Reset</button>
					<button id="applyFilter" class="btn btn-primary">Apply</button>
				</div>
				</div>
		</div>
	</div>
	<div class="section">
		<div class="row">
			<div class="col-md-12">
				<div class="page-head">
					<h2 class="page-title"><?= $pageTitle ?></h2>
					<div class="filter-block">
						<div class="search">
							<input type="text" id="search_name" placeholder="Search by name" autocomplete="off" />
							<i class="fa fa-search"></i>
						</div>
						<div class="btn-groups info-wrapper">
							<?php if($resetIcon) { ?>
							<a href="<?= Yii::app()->createAbsoluteUrl('/' . ltrim(Yii::app()->user->partner_slug . '/myleads')); ?>" class="reset-filter info" data-title="My Leads">
								<i class="fa fa-repeat" aria-hidden="true"></i>
								<span class="details">Reset</span>
							</a>
							<?php } ?>
							 <div class="filter-btn info">
								<i class="fa fa-filter"></i>
								<span class="details">Apply Filter</span>
							</div>
							<div class="export-btn info" id="exportCsv">
								<i class="fa fa-download" aria-hidden="true"></i>
								<span class="details">Export Leads</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php $this->widget("zii.widgets.grid.CGridView", [
					"id" => "customer-lead-grid",
					"dataProvider" => $model->search_new(),
					"rowCssClassExpression" => "",
					"filter" => null,
					"summaryText" => "Showing {start}–{end} of {count} Leads",
					"template" => "{items}\n<div class=\"pagination-container\"><div id=\"lead-count\" class=\"text-muted\" style=\"font-size:14px;\">{summary}</div><div class=\"pager-buttons\">{pager}</div></div>",
					"itemsCssClass" => "table table-bordered table-striped table-condensed flip-content",
					"afterAjaxUpdate" => "function(){ toggleExportButton(); }",
					"pager" => [
						"cssFile" => false,
						"htmlOptions" => ["class" => "pagination"],
						"header" => "",
						"firstPageLabel" => "<i class=\"fa fa-angle-double-left\"></i>",
						"prevPageLabel" => "<i class=\"fa fa-angle-left\"></i>",
						"nextPageLabel" => "<i class=\"fa fa-angle-right\"></i>",
						"lastPageLabel" => "<i class=\"fa fa-angle-double-right\"></i>",
					],
					"columns" => [
						["name" => "id", 'htmlOptions'=> ['style' => 'width:8%;'],],
						["name" => "ss_lead_id","header" => "SS ID"],
						[
							"name" => "name",
							"type" => "raw",
							"value" => 'ucwords(strtolower($data->name))'
						],
						[
							"name" => "date",
							"value" => '($data->date == 0000-00-00) ? "Not Set" : date_format(new DateTime($data->date), "d-m-Y H:i")',
						],
						[
							"name" => "city",
							"value" => 'ucwords(strtolower($data->city))',
						],
						[
							"name" => "ip_country",
							"value" => '$data->ip_country=="India"?$data->ip_country : (($data->ip_country=="")? "":"$data->ip_country")',
						],
						[
							"name" => "status",
							"type" => "raw",
							'headerHtmlOptions' => ['style' => 'text-align:center'], 
							'htmlOptions'=> ['style' => 'text-align:center'],
							"value" => function($data) {
								$status = trim($data->status);
								$displayStatus = $status;
								
								if ($status == "JunkLead") {
									$displayStatus = "Junk Lead";
								} elseif ($status == "Avoided(No-Vendor)") {
									$displayStatus = "No-Vendor";
								}
								
								// Get first word of status for CSS class name
								$statusWords = explode(' ', $status);
								$firstWord = strtolower($statusWords[0]);
								$firstWordParts = explode('(', $firstWord);
								$firstWord = $firstWordParts[0];
								$badgeClass = "badge badge-" . $firstWord;
								return '<span class="'.$badgeClass.'">'.$displayStatus.'</span>';
							}
						],
						[
							"header" => "Category",
							"type" => "raw",
							"name" => "categories",
							"value" => function($data) {
								return isset($data->category_reference) && isset($data->category_reference->name)
									? $data->category_reference->name
									: "";
							},
							"htmlOptions" => ["style" => "text-align:left;width:200px"],
						],
						[
							'header'=>'View',
							'name'=>'',
							'headerHtmlOptions' => ['style' => 'text-align:center'], 
							'htmlOptions'=> ['class'=>'k_tbl_c eye_icon_inner', 'align'=>'center'],
							'value'=> function($data) {
								echo '<button class="view-lead-btn" data-popup-ordinal="0" onclick="show('.$data["id"].');" type="button"><img src="'.Yii::app()->baseUrl.'/images/lead_view_icon/lv_eye_i.svg" alt="lead view"></button>';
							}
						],
					],
				]); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	const urlParams = new URLSearchParams(window.location.search);
	const daterangeParam = urlParams.get('date_range');
	const leadType = "<?= $leadType ?>";

	function show(id)
	{ 
		$.ajax
		({ 
			url: '<?php echo Yii::app()->request->getBaseUrl(true);?>/index.php?r=customerLead/moreinfo',
			data: {"lid":id},
			type: 'GET',
			beforeSend : function (){ 
				$('#basic').html('Please wait..loading data');
			},
			success: function(result)
			{    
				$('.visibility_main').show();
				$('#basic').html(result);
			}
		});
	}

	$(document).on('click','#close_popup',function(){
		$('.visibility_main').hide();
	});

	$(document).on('click', '.visibility_main', function(e) {
		if ($(e.target).closest('.inner').length === 0) {
			$('.visibility_main').hide();
		}
	});


	$('.filter-btn').click(function () {
		$('#filterBox').fadeIn(200);
	});

	$('#closeFilter, .filter-popup-overlay, .filter-popup-header .close-icon').click(function () {
		$('#filterBox').fadeOut(200);
	});

	$('#applyFilter').click(function () {
		var category = $('#filter_category').val(); // array
		var country  = $('#filter_country').val();  // array
		var status   = $('#filter_status').val();   // array
		var daterange = $('#filter_daterange').val();

		$('#customer-lead-grid').yiiGridView('update', {
			data: {
				category: category,
				country: country,
				status: status,
				daterange: daterange,
			}
		});
		$('#filterBox').fadeOut(200);
	});

	$('.multiselect').select2({
		placeholder: "Please select",
		dropdownParent: $('.filter-popup-body')
	});

	// If page type is verified or qualified
	if (leadType === 'verified' || leadType === 'qualified') {
		$('#filter_status option').prop('selected', true);
		$('#filter_status').prop('disabled', true);
		$('#filter_status').trigger('change.select2');
	}

	$('#resetFilter').click(function () {

		if (!daterangeParam) {
			$('#filter_daterange').val('');
		}

		$(".multiselect").each(function () {
			const id = $(this).attr('id');

			if (id === 'filter_status' && (leadType === 'verified' || leadType === 'qualified')) {
				return;
			}

			$(this).val(null).trigger('change');
		});

		const preservedFilters = {};

		if (daterangeParam) {
			preservedFilters['daterange'] = daterangeParam;
		}

		// Preserve status if leadType = verified or qualified
		if (leadType === 'verified' || leadType === 'qualified') {
			const preservedStatus = $('#filter_status').val();
			if (preservedStatus && preservedStatus.length) {
				preservedFilters['status'] = preservedStatus;
			}
		}

		$('#customer-lead-grid').yiiGridView('update', {
			data: preservedFilters
		});
	});

	$('#filter_daterange').daterangepicker({
    	minDate: moment("<?=$start_date?>", "YYYY-MM-DD HH:mm:ss"),
		maxDate: moment(),
		"opens": "center",
		locale: { cancelLabel: 'Clear' }  
	}).val('');

	$('.date-field i').on('click', function () {
		$('#filter_daterange').trigger('click');
	});

	$('#filter_daterange').on('cancel.daterangepicker', function(ev,picker) {
		picker.setStartDate(moment());
		picker.setEndDate(moment()); 
		$(this).val('');
    });

	// Debounced type-to-search on name field, updates grid via CustomerLead[name]
	let __nameSearchTimer = null;
	$('#search_name').on('keyup change', function(){
		const nameVal = $.trim($(this).val());
	    const validNameRegex = /^[A-Za-z\s'-]+$/;
		
		clearTimeout(__nameSearchTimer);
		__nameSearchTimer = setTimeout(function(){
			if (nameVal === '' || validNameRegex.test(nameVal)) {
				$('#customer-lead-grid').yiiGridView('update', {
					data: {
						'CustomerLead[name]': nameVal
					}
				});
			} else {
				return;
			}
		}, 300);
	});

	// Export CSV
	$('#exportCsv').on('click', function (e) {
		e.preventDefault();

		const exportBaseUrl = "<?=$this->createUrl('customerLead/export', ['partner_slug' => $partner_slug])?>";
		const leadType = "<?=$lead_type?>";
		const params = {};
		const nameVal = $.trim($('#search_name').val());
		const validNameRegex = /^[A-Za-z\s'-]+$/;

		if (nameVal !== '' && validNameRegex.test(nameVal)) {
			params['CustomerLead[name]'] = nameVal;
		}

		const category = $('#filter_category').val();
		if (Array.isArray(category) && category.length) {
			params['category'] = category;
		}

		const country = $('#filter_country').val();
		if (Array.isArray(country) && country.length) {
			params['country'] = country;
		}

		const status = $('#filter_status').val();
		if (Array.isArray(status) && status.length) {
			params['status'] = status;
		}

		const daterange = $('#filter_daterange').val();
		if (daterange) {
			params['daterange'] = daterange;
		}

		if (leadType) {
			params['lead_type'] = leadType;
		}

		const queryString = $.param(params);
		window.location = exportBaseUrl + (queryString ? (exportBaseUrl.indexOf('?') === -1 ? '?' : '&') + queryString : '');
	});

	$(".reset-filter").on('click', function () {
		$(this).remove();
	})

	// If loaded from dashboard, select and disable datepicker filter.
	if (daterangeParam && daterangeParam.includes('_')) {
		const [start, end] = daterangeParam.split('_');
		const startDate = moment(start, 'YYYY-MM-DD');
		const endDate = moment(end, 'YYYY-MM-DD');

		$('#filter_daterange').data('daterangepicker').setStartDate(startDate);
		$('#filter_daterange').data('daterangepicker').setEndDate(endDate);

		$('#filter_daterange').val(
			`${startDate.format('MMM DD YYYY')} - ${endDate.format('MMM DD YYYY')}`
		);

		$('#filter_daterange').prop('disabled', true);
	}

	function toggleExportButton() {
		const rowCount = $('#customer-lead-grid table tbody tr').length;
		const isNoData = rowCount === 1 && 
			$('#customer-lead-grid table tbody tr td').first().text().toLowerCase().includes("no");

		if (rowCount === 0 || isNoData) {
			$('#exportCsv').addClass('disabled');
		} else {
			$('#exportCsv').removeClass('disabled');
		}
	}

	toggleExportButton();

</script>
