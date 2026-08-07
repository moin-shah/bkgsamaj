<?php

class CustomerLead extends CActiveRecord
{
    

	public function tableName()
	{         
		return 'customer_lead';     
	}
	public function rules()
	{
		return array(
            array('name,email,mobile,categories,status,source', 'required'),
            array('designation,company,city,state,industry,deployment,no_of_users,no_of_employees,email,name,mobile,ip,countrycode,browser', 'length'),
            array('id,ss_lead_id,name,email,mobile,company,state,city,status,source,date,deployment,no_of_users,no_of_employees,industry,conversion_rate,ip,ip_city,ip_country,browser,countrycode,categories,sell_live_on_date', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		
		return array(
			'category_reference'=>array(self::BELONGS_TO, 'Categories', 'categories'),
            // Removed unrelated relations
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'email' => 'Email',
			'mobile' => 'Mobile',
			'countrycode' => 'countrycode',
			'company' => 'Company',
			'city'=> 'City',
            'ip_city'=> 'IP City',
            'ip_country'=> 'Country',
			'status' => 'Status',
			'categories' => 'Category',
			'source' => 'Source',
            'deployment' => 'Deployment',
			'no_of_users' => 'No of Users',
            'no_of_employees' => 'No of Employees',
			'industry' => 'Industry',
			'date'=>'Date',
			'state'=>'State',
			'designation'=>'Designation',
            'sell_live_on_date' => 'Sell Live On Date',
            'ss_lead_id' => 'SS Lead ID',
            'conversion_rate' => 'Conversion Rate',
            'ip' => 'IP Address',
            'browser' => 'Browser',
		);
	}

	public function getFunProcessed()
	{
		$status_arr = array('JunkLead_'.$this->id=>'JunkLead','New Lead_'.$this->id=>'New Lead',
			'Attempt 1_'.$this->id=>'Attempt 1',
			'Attempt 2_'.$this->id=>'Attempt 2',
			'Attempt 3_'.$this->id=>'Attempt 3',
			'Attempt 4_'.$this->id=>'Attempt 4',
			'Attempt 5_'.$this->id=>'Attempt 5',
			'Attempt 6_'.$this->id=>'Attempt 6',
			'Attempt 7_'.$this->id=>'Attempt 7',
			'Double_'.$this->id=>'Double',
			'Qualified_'.$this->id=>'Qualified',
			'Requirement over_'.$this->id=>'Requirement over',
			'Not Interested_'.$this->id=>'Not Interested',
			'E-mail_'.$this->id=>'E-mail',
			'Closed_'.$this->id=>'Closed',
			'Avoided(No-Vendor)_'.$this->id=>'Avoided(No-Vendor)',
			'Avoided(Other)_'.$this->id=>'Avoided(Other)',
			'Vendor_'.$this->id=>'Vendor',
			'Discussion_'.$this->id=>'Discussion',
			'Partner Qualified_'.$this->id=>'Partner Qualified',
			'No idea about SS_'.$this->id=>'No idea about SS',
			'Research Purpose_'.$this->id=>'Research Purpose',
		);
		if($this->status == 'New Lead' || $this->status == 'Double')
		{
			unset($status_arr['Discussion_'.$this->id]);
		}
		return CHtml::dropDownList('status_'.$this->id, 
			$this->status.'_'.$this->id, $status_arr,
			array(
				'onchange'=>'myfunction('.$this->id.')',  


				'style' => 'width:auto;text-align:center',
				'data-status' => $this->status,
				'data-country' => $this->ip_country)

		);
	}

	public function search_new($pagination = true)
	{
		$uname=Yii::app()->user->name;
		
		if(!isset($_GET['partner_slug']) && empty($_GET['partner_slug']))
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
		$criteria=new CDbCriteria;
		$criteria->select="t.id,t.ss_lead_id,t.name,t.email,t.mobile,t.company,t.designation,t.city,t.state,t.ip_country,t.categories,t.industry,t.main_criteria_units,t.main_criteria_label,t.deployment,t.status,t.source,t.date,t.sell_live_on_date,t.countrycode";
		$criteria->compare('t.id',$this->id);
        $criteria->compare('t.ss_lead_id',$this->ss_lead_id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('city',$this->city,true);
		
        if ($this->ip_country === 'Global' || $this->ip_country === 'global') {
			$criteria->addCondition("ip_country != 'India' AND ip_country != ''");
		} else {
			$criteria->compare('ip_country',$this->ip_country,true);
		}

		$criteria->addInCondition('status', [
			'New Lead','Attempt 1','Attempt 2','Attempt 3','Attempt 4','Attempt 5','Attempt 6','Attempt 7',
			'Double','Qualified','JunkLead','Not Interested','Avoided(No-Vendor)'
		]);

		
		$criteria->compare('t.status',$this->status,true);
		if(!empty($this->categories)){
			$criteria->with = array('category_reference',array('alias'=>'cv1'));
			$criteria->together = true;
			$criteria->compare('category_reference.id',$this->categories);
		}

		// Apply custom filter inputs coming from the view (arrays + date range)
		$request = Yii::app()->request;
		/* echo "<pre>";
		print_r($request);
		echo "<br>";
		exit; */
		$filterCategories = $request->getParam('category', []);
		$filterCountries  = $request->getParam('country', []);
		$filterStatuses   = $request->getParam('status', []);
		$filterDaterange  = trim($request->getParam('daterange', ''));

		if (!empty($filterCategories) && is_array($filterCategories)) {
			// categories is a FK id on the row; support multi-select
			$criteria->addInCondition('t.categories', array_filter($filterCategories));
		}

		if (!empty($filterCountries) && is_array($filterCountries)) {
			$criteria->addInCondition('t.ip_country', array_filter($filterCountries));
		}

		if (!empty($filterStatuses) && is_array($filterStatuses)) {
			$criteria->addInCondition('t.status', array_filter($filterStatuses));
		}

		if (!empty($filterDaterange)) {
			$parts = array_map('trim', explode(' - ', $filterDaterange));
			if (count($parts) === 2) {
				$startDate = date('Y-m-d 00:00:00', strtotime($parts[0]));
				$endDate   = date('Y-m-d 23:59:59', strtotime($parts[1]));
				$criteria->addBetweenCondition('t.date', $startDate, $endDate);
			}
		}

		$leadType = strtolower($request->getParam('lead_type', ''));
		$date_range = $request->getParam('date_range', '');
		if ($leadType === 'verified') {
			$criteria->addNotInCondition('t.status', array('Avoided(No-Vendor)', 'Double'));
		} elseif ($leadType === 'qualified') {
			$criteria->compare('t.status', 'Qualified', false);
		}

		if(!empty($date_range))
		{
			list($start, $end) = array_map('trim', explode('_', $date_range));
			$startDate = date('Y-m-d 00:00:00', strtotime($start));
			$endDate   = date('Y-m-d 23:59:59', strtotime($end));
			$criteria->addBetweenCondition('t.date', "{$startDate} 00:00:00", "{$endDate} 23:59:59");
		}

		$criteria->compare('source',Yii::app()->user->partner_source,true);
        $criteria->compare('deployment',$this->deployment,true);
        $criteria->compare('main_criteria_units',$this->main_criteria_units,true);
        $criteria->compare('industry',$this->industry,true);
		$criteria->compare('date',$this->date,true);
        $criteria->compare('designation',$this->designation,true);
        $criteria->compare('state',$this->state,true);
		$criteria->order = 'date DESC';
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
			'pagination' => $pagination ? array(
				'pageSize' => 10,
			) : false,
			'sort' => false,
		));
	}

	public function getGridviewStatus(){
		return array('New Lead'=>'New Lead','Attempt 1'=>'Attempt 1','Attempt 2'=>'Attempt 2','Attempt 3'=>'Attempt 3','Attempt 4'=>'Attempt 4','Attempt 5'=>'Attempt 5','Attempt 6'=>'Attempt 6','Attempt 7'=>'Attempt 7','Double'=>'Double','Qualified'=>'Qualified','JunkLead'=>'Junk Lead','Requirement over'=>'Requirement over','Not Interested'=>'Not Interested','E-mail'=>'E-mail','Closed'=>'Closed','Avoided(No-Vendor)'=>'Avoided(No-Vendor)','Avoided(Other)'=>'Avoided(Other)','Vendor'=>'Vendor','Discussion'=>'Discussion','Partner Qualified'=>'Partner Qualified','No idea about SS'=>'No idea about SS','Research Purpose'=>'Research Purpose');
	}
	public function getGridviewSource(){
		return array('RequestDemo'=>'Request Demo','Partner'=>'Partner','Request a CallBack'=>'Request a CallBack','GetQuote'=>'Get Quote','Compare'=>'Compare','FreeConsultation'=>'Free Consultation','FreeDownloadBooks'=>'FreeDownload Books','GetListed'=>'Get Listed','Live Support'=>'Live Support','Inbound Call'=>'Inbound Call','Buy'=>'Buy','Reseller Request'=>'Reseller Request','RequestaCallbackApp'=>'Request a CallBack App','Tools'=>'Tools','Technology Advice'=>'Technology Advice','Post Buy Requirement'=>'Post Buy Requirement','Widget'=>'Widget','AskQuestion'=>'Ask A Question','Landing Page'=>'Landing Page','Top Ten Insider'=>'Top Ten Insider','Vendors Lead'=>'Vendors Lead','Google'=>'Google','facebook'=>'Facebook','FacebookPartner'=>'FacebookPartner','LINKEDIN'=>'LINKEDIN','Google'=>'Google','ExitIntent'=>'ExitIntent','sendinblue'=>'Sendinblue','Services'=>'Services','holistic'=>'Holistic','UCFreeconsultation'=>'UCFreeconsultation','UCLearnmore'=>'UCLearnmore','consultant'=>'consultant','MobileAppRequestDemo'=>'MobileAppRequestDemo','MobileAppGetQuote'=>'MobileAppGetQuote','Taboola'=>'Taboola','Bing'=>'Bing','Resources'=>'Resources','Quora'=>'Quora','buyersguide'=>'buyersguide','Inbound Caller'=>'Inbound Caller','ZenSuggest'=>'ZenSuggest','ebook'=>'ebook','lquote'=>'lquote','Internal incoming'=>'Internal incoming','Useful'=>'Useful','Business Requirement'=>'Business Requirement','Organic Social Media'=>'Organic Social Media','Fbad'=>'Fbad','Goad'=>'Goad','revstack'=>'Revstack','partnerstack'=>'Partnerstack','MVF-CPL'=>'MVF-CPL');
	}
	public function getGridviewReseller(){
		return array('0'=>'No','1'=>'Yes');
	}
	public function getGridviewLimit(){
		return array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6');
	}

	public function getGridviewBaseUrl()
	{
		return array('google.co.in'=>'Google','quora.com'=>'Quora','googleadservices.com'=>'Google Ad','BKGS.com'=>'BKGS');
	}

	public function getGridviewLeadValue(){
		return array('50'=>'50','75'=>'75','100'=>'100','125'=>'125','150'=>'150','175'=>'175','200'=>'200','250'=>'250','300'=>'300','350'=>'350','400'=>'400');
	}

	public function getGridviewAllTimeFrame(){
		return array('1 week'=>'1 week', '2 week'=>'2 week', '1 month'=>'1 month', '2 months'=>'2 months','3 months'=>'3 months','6 months'=>'6 months');
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}