<?php

class CustomerLeadController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $defaultAction = 'dashboard';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin','dashboard','namelist','cdlist','categorylist','chkcategorycriteria','maincriteria','getcity','getstate','moreinfo','getleadcounts','export'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionAdmin()
	{   
		$partner_slug = isset($_GET['partner_slug']) ? $_GET['partner_slug'] : null;
		
		if (!empty($partner_slug)) 
		{
			$vendor=PartnerMasters::model()->findByAttributes(array('slug'=>$partner_slug));
			
			if (!$vendor) 
			{
				throw new CHttpException(404, 'Vendor not found');
				exit;
			}

			$this->layout='//layouts/column2';
			$this->pageTitle =  Yii::app()->user->partner_name.' - My Leads';

			$request = Yii::app()->request;
			$leadType = strtolower($request->getParam('lead_type', ''));
			$daterange = $request->getParam('daterange', '');
			$allowedLeadTypes = array('verified', 'qualified');
			if (!in_array($leadType, $allowedLeadTypes)) {
				$leadType = '';
			}

			$model=new CustomerLead('search');
			$model->unsetAttributes();

			if(isset($_GET['CustomerLead']))
			{
				$model->attributes=$_GET['CustomerLead'];
			}
			$partner_source = Yii::app()->user->partner_source;

			$statusCondition = '';
			$leadFilterCondition = '';
			$dateCondition = '';
			if ($leadType === 'verified') {
				$statusCondition = " AND status NOT IN ('Avoided(No-Vendor)','Double')";
				$leadFilterCondition = " AND customer_lead.status NOT IN ('Avoided(No-Vendor)','Double')";
			} elseif ($leadType === 'qualified') {
				$statusCondition = " AND status = 'Qualified'";
				$leadFilterCondition = " AND customer_lead.status = 'Qualified'";
			}
			
			if(!empty($daterange))
			{
				list($start, $end) = array_map('trim', explode('_', $daterange));
				$start_date = date('Y-m-d 00:00:00', strtotime($start));
				$end_date   = date('Y-m-d 23:59:59', strtotime($end));
				$dateCondition = " AND date BETWEEN '{$start_date}' AND '{$end_date}'";
			}

			$categorylist = Yii::app()->db->createCommand("SELECT customer_lead.categories AS id,categories.name as name FROM customer_lead LEFT JOIN categories ON categories.id = customer_lead.categories WHERE source = '{$partner_source}' {$leadFilterCondition} {$dateCondition} GROUP BY customer_lead.categories ORDER BY categories.name ASC")->queryAll();
			$category_list = array_column($categorylist, 'name','id');

			$leadstatus = Yii::app()->db->createCommand("SELECT status FROM customer_lead WHERE source = '{$partner_source}' {$statusCondition} {$dateCondition} GROUP BY status ORDER BY status ASC")->queryAll();
			$lead_status_list = array_column($leadstatus, 'status');

			$leadcountry = Yii::app()->db->createCommand("SELECT ip_country FROM customer_lead WHERE source = '{$partner_source}' {$statusCondition} {$dateCondition} GROUP BY ip_country ORDER BY ip_country ASC")->queryAll();
			$lead_country_list = array_column($leadcountry, 'ip_country');
			
			$start_date = Yii::app()->db->createCommand("SELECT date FROM customer_lead WHERE source = '{$partner_source}' {$statusCondition} {$dateCondition} ORDER BY date ASC")->queryScalar();

			if (empty($start_date)) {
				$start_date = '2025-10-01';
			}

			$this->render('lead_admin',array(
				'model'=>$model,
				'partner_slug'=>$partner_slug,
				'category_list'=>$category_list,
				'lead_status_list'=>$lead_status_list,
				'lead_country_list'=>$lead_country_list,
				'start_date'=>$start_date,
				'lead_type'=>$leadType
			));
		} 
		else 
		{
			throw new CHttpException(404, 'Vendor not found');
			exit;
		}
	}
	public function actionDashboard()
	{   
		$partner_slug = isset($_GET['partner_slug']) ? $_GET['partner_slug'] : null;
		
		if (!empty($partner_slug)) 
		{
			$vendor=PartnerMasters::model()->findByAttributes(array('slug'=>$partner_slug));
			
			if (!$vendor) 
			{
				throw new CHttpException(404, 'Vendor not found');
				exit;
			}

			$this->layout='//layouts/column2';
			$this->pageTitle = Yii::app()->user->partner_name.' - Lead Overview';

			$partner_source = Yii::app()->user->partner_source;

			$model=new CustomerLead('search');
			$model->unsetAttributes();

			if(isset($_GET['CustomerLead']))
			{
				$model->attributes=$_GET['CustomerLead'];
			}

			$lead_data = Yii::app()->db->createCommand("
				SELECT 
				COUNT(id) AS total,
				COUNT(CASE WHEN status='Qualified' THEN id END) AS qualified,
				COUNT(DISTINCT CASE WHEN status NOT IN ('Avoided(No-Vendor)','Double') THEN id END) AS verified
				FROM customer_lead
				WHERE source = '{$partner_source}' AND status IN('New Lead','Attempt 1','Attempt 2','Attempt 3','Attempt 4','Attempt 5','Attempt 6','Attempt 7',
					'Double','Qualified','JunkLead','Not Interested','Avoided(No-Vendor)')
				")->queryRow();

			$formatter = new NumberFormatter('en_IN', NumberFormatter::DECIMAL);

			$conversion_rate = Yii::app()->user->conversion_rate;
			$stack_percent = Yii::app()->user->stack_percent;

			$revenue = Yii::app()->db->createCommand("SELECT SUM(lead_revenue) as lead_revenue FROM customer_lead WHERE source = '{$partner_source}'")->queryScalar();
			$stack_amount = ($revenue * $stack_percent) / 100;

			$lead_data['revenue_inr'] = $formatter->formatCurrency($stack_amount, 'INR');
			$lead_data['revenue_usd'] = $formatter->formatCurrency(round(($stack_amount/$conversion_rate),2), 'USD');
			
			$data = Yii::app()->db->createCommand("SELECT DATE(date) AS date, COUNT(id) AS leads FROM customer_lead WHERE DATE(date) BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND CURDATE() AND source = '{$partner_source}' AND status IN('New Lead','Attempt 1','Attempt 2','Attempt 3','Attempt 4','Attempt 5','Attempt 6','Attempt 7','Double','Qualified','JunkLead','Not Interested','Avoided(No-Vendor)') GROUP BY DATE(date) ORDER BY DATE(date)")->queryAll();

			$start_date = Yii::app()->db->createCommand("SELECT date FROM customer_lead WHERE source = '{$partner_source}' ORDER BY date ASC")->queryScalar();
			if (empty($start_date)) {
				$start_date = '2025-10-01';
			}
			$start_date = date('M d Y', strtotime($start_date));

			$stats_arr = [];
			for ($i = 6; $i >= 0; $i--) {
				$date = date('Y-m-d', strtotime("-{$i} days"));
				$stats_arr[$date] = 0;
			}
			foreach ($data as $row) {
				$stats_arr[$row['date']] = (int)$row['leads'];
			}

			$labels = [];
			$values = [];

			foreach ($stats_arr as $date => $value) {
				$labels[] = "'" . date('M j', strtotime($date)) . "'"; 
				$values[] = (int)$value;
			}
			$label_string = implode(', ', $labels);
			$lead_counts = implode(', ', $values);

			$this->render('dashboard',array(
				'model'=>$model,
				'lead_data'=>$lead_data,
				'partner_slug'=>$partner_slug,
				'partner_source'=>$partner_source,
				'stats_arr'=>$stats_arr,
				'label_string'=>$label_string,
				'lead_counts'=>$lead_counts,
				'start_date'=>$start_date
			));
		} 
		else 
		{
			throw new CHttpException(404, 'Vendor not found');
			exit;
		}
	}
	public function actionCategorylist()
	{
		$id=$_POST['id'];

		$data1="SELECT categories,source from customer_lead where id='".$id."'";
		$data = CustomerLead::model()->findBySql($data1);

		if(isset($data->categories))
		{
			$categorySoftware=Yii::app()->db->createCommand('SELECT name, id FROM categories where id ='.$data->categories)->queryRow();
			if($categorySoftware['name']=="unknown industry" && $data['source']=="RequestaCallbackApp")
			{
				echo "HOME";
			}
			else
			{
				echo $categorySoftware['name'];
			}
		}
		else 
		{
			if($data['source']=="RequestaCallbackApp")
			{
				echo "HOME";
			}
		}
	}
	public function loadModel($id)
	{
		$model=CustomerLead::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customer-lead-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionGetstate()
	{            
		$city1=$_POST['city'];
		$country = $_POST['country'];

		if($city1!=''){
			$url="http://maps.googleapis.com/maps/api/geocode/json?address=".$country.','.$city1."&sensor=true";


			$address_info = file_get_contents($url);
			$json = json_decode($address_info);



			$state = "";

			if (count($json->results) > 0) {


				$arrComponents = $json->results[0]->address_components;


				foreach($arrComponents as $index=>$component) {
					$type = $component->types[0];



					if ($state == "" && $type=="administrative_area_level_1") {
						$state = trim($component->long_name);
					}

					if ($city1 != "" && $state != "" && $country != "") {

						break;
					}
				}
			}

			$mainStateArray = array("state"=>$state);


			echo json_encode($mainStateArray);
		}
	}

	public function actionChkCategoryCriteria()
	{
		if(isset($_POST['cat']) && $_POST['cat']!=""){
			$cat_id=$_POST['cat'];
			$sqlpc = "SELECT * FROM category_pricing_criteria WHERE category_id = $cat_id";
			$catExist = Yii::app()->db->createCommand($sqlpc)->queryAll();
			$data = array();
			if(!empty($catExist) && count($catExist)>0){
				$units=Array();
				$lbl = $catExist[0]['label_name'];
				foreach ($catExist as $row) {
					$units[] = $row['units'];
				}
			}
			if(!empty($lbl) && $lbl!=""){
				$data = array(
					'label'=>ucfirst($lbl),
					'units'=>$units
				);
			}else{
				$data = array(
					'label'=>"",
					'units'=>""
				);
			}
			echo json_encode($data);die;
		}
	}
	public function chkLoadCategoryCriteria($cat_id){
		
		if(!empty($cat_id) && $cat_id!=""){
			$sqlpc = "SELECT units FROM category_pricing_criteria WHERE category_id = $cat_id";
			$catExist = Yii::app()->db->createCommand($sqlpc)->queryAll();
			return $catExist;
		}
	}
	public function actionMaincriteria()
	{
		$id = $_POST['id'];
		$model=$this->loadModel($id);
		$catPricingData = $this->chkLoadCategoryCriteria($model->categories);
        // Field removed from schema; keep empty to avoid referencing non-existent attribute
        $selectedUnit = '';
		if(!empty($catPricingData))
		{
			$unitArray=array();			
			foreach ($catPricingData as $key => $row)
			{
				$unitArray[] = $row['units'];
			}
		}
		echo '<select class="form-control" name="CustomerLead[main_criteria_units]" id="CustomerLead_main_criteria_units">';
		if(!empty($unitArray))
		{ 
			foreach($unitArray as $row)
			{?> 
				<option <?php if($selectedUnit==$row){ echo "selected"; } ?> value="<?php echo $row ?>"><?php echo $row ?></option>				
			<?php } 
		}
		echo '</select>';
	}

	public function actionmoreinfo()
	{
		$id = $_GET['lid'];
		$model = $this->loadModel($id);
		
		$this->renderPartial('lead_view',array(
			'model'=>$model,
		));
	}
	public function actionGetleadcounts()
	{
		$daterange = Yii::app()->request->getPost('daterange', '');
		if(!empty($daterange))
		{
			list($start, $end) = array_map('trim', explode(' - ', $daterange));

			$start_date = date('Y-m-d 00:00:00', strtotime($start));
			$end_date   = date('Y-m-d 23:59:59', strtotime($end));
		}
		$partner_source = Yii::app()->user->partner_source;

		$date_condition = '';
		$qualified_date_condition = '';

		if (!empty($start_date) && !empty($end_date)) 
		{
			$date_condition = "date BETWEEN '{$start_date}' AND '{$end_date}'";
			$qualified_date_condition = "sell_live_on_date BETWEEN '{$start_date}' AND '{$end_date}'";
		} 
		else 
		{
			$date_condition = '1';
			$qualified_date_condition = '1';
		}
		
		$result = Yii::app()->db->createCommand("
			SELECT 
			COUNT(CASE WHEN {$date_condition} THEN id END) AS total,
			COUNT(CASE WHEN status='Qualified' AND {$qualified_date_condition} THEN id END) AS qualified,
			COUNT(DISTINCT CASE WHEN status NOT IN ('Avoided(No-Vendor)','Double') AND {$date_condition} THEN id END) AS verified
			FROM customer_lead
			WHERE source = '{$partner_source}' AND status IN('New Lead','Attempt 1','Attempt 2','Attempt 3','Attempt 4','Attempt 5','Attempt 6','Attempt 7',
			'Double','Qualified','JunkLead','Not Interested','Avoided(No-Vendor)')
			")->queryRow();
		$formatter = new NumberFormatter('en_IN', NumberFormatter::DECIMAL);

		$conversion_rate = Yii::app()->user->conversion_rate;
		$stack_percent = Yii::app()->user->stack_percent;

		$revenue = Yii::app()->db->createCommand("SELECT SUM(lead_revenue) as lead_revenue FROM customer_lead WHERE source = '{$partner_source}' AND {$date_condition}")->queryScalar();
		$stack_amount = ($revenue * $stack_percent) / 100;
		
		$result['revenue_inr'] = $formatter->formatCurrency($stack_amount, 'INR');
		$result['revenue_usd'] = $formatter->formatCurrency(round(($stack_amount/$conversion_rate),2), 'USD');
		
		echo CJSON::encode($result);
		exit();
	}

	public function actionExport()
	{
		$partner_slug = Yii::app()->request->getParam('partner_slug', null);

		if (empty($partner_slug)) {
			throw new CHttpException(404, 'Vendor not found');
		}

		$vendor = PartnerMasters::model()->findByAttributes(array('slug' => $partner_slug));
		if (!$vendor) {
			throw new CHttpException(404, 'Vendor not found');
		}

		$model = new CustomerLead('search');
		$model->unsetAttributes();

		if (isset($_GET['CustomerLead'])) {
			$model->attributes = $_GET['CustomerLead'];
		}

		$dataProvider = $model->search_new(false);
		$leads = $dataProvider->getData();

		$filename = 'All Leads.csv';

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);

		$output = fopen('php://output', 'w');
		fputcsv($output, array(
			'ID',
			'NAME',
			'EMAIL ADDRESS',
			'CONTACT',
			'COMPANY',
			'DESIGNATION',
			'CITY',
			'STATE',
			'COUNTRY',
			'CATEGORY',
			'INDUSTRY',
			'MAIN CRITERIA',
			'DEPLOYMENT',
			'STATUS',
			'SUBMISSION DATE',
			'QUALIFIED DATE'
		));


		$formatValue = function ($value) {
			if (is_string($value)) {
				$value = trim($value);
			}
			return ($value === null || $value === '') ? '-' : $value;
		};

		foreach ($leads as $lead) {
			$categoryName = '';
			if (isset($lead->category_reference) && isset($lead->category_reference->name)) {
				$categoryName = $lead->category_reference->name;
			}

			$dateValue = $lead->date;
			if (!empty($dateValue) && $dateValue !== '0000-00-00' && $dateValue !== '0000-00-00 00:00:00') {
				$dateValue = date('d-m-Y', strtotime($dateValue));
			} else {
				$dateValue = '';
			}

			$sellLiveOnDate = $lead->sell_live_on_date;
			if (!empty($sellLiveOnDate) && $sellLiveOnDate !== '0000-00-00' && $sellLiveOnDate !== '0000-00-00 00:00:00') {
				$sellLiveOnDate = date('d-m-Y', strtotime($sellLiveOnDate));
			} else {
				$sellLiveOnDate = '';
			}

			$phoneNumber = $lead->mobile;
			if (!empty($lead->countrycode)) {
				$phoneNumber = $lead->countrycode . ' ' . $lead->mobile;
			}

			if($lead->main_criteria_label == "NA"){
				$main_criteria = $lead->main_criteria_label;
			} else {
				$main_criteria = $lead->main_criteria_label .": ".$lead->main_criteria_units;
			}

			fputcsv($output, array(
				$formatValue($lead->id),
				$formatValue(ucwords(strtolower($lead->name))),
				$formatValue($lead->email),
				$formatValue($phoneNumber),
				$formatValue($lead->company),
				$formatValue($lead->designation),
				$formatValue(ucwords(strtolower($lead->city))),
				$formatValue($lead->state),
				$formatValue($lead->ip_country),
				$formatValue($categoryName),
				$formatValue($lead->industry),
				$formatValue($main_criteria),
				$formatValue($lead->deployment),
				$formatValue($lead->status),
				$dateValue !== '' ? $dateValue : '-',
				$sellLiveOnDate !== '' ? $sellLiveOnDate : '-',
			));
		}

		fclose($output);
		$insert_data = array(
			'partner_id'=>Yii::app()->user->partner_id,
			'email'=>Yii::app()->user->email,
			'datetime'=>date('Y-m-d H:i:s'),
		);
		Yii::app()->db->createCommand()->insert('lead_data_export_log',$insert_data);
		Yii::app()->end();
	}
}
	