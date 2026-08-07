<style>
    .lead-details-container{
        background: #FFFFFF;
    }
    .lead-header{
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px;
        border-bottom: 1px solid #e6e6e6;
        position: relative;
    }
    .lead-avatar{
        width: 40px;
        height: 40px;
        background: #4A75BC;
        color: white;
        border-radius: 8px !important;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size: 16px;
        color: #FFFFFF;
        font-weight:700;
        box-shadow: 0 7.044px 10.566px -2.113px rgba(0, 0, 0, 0.10);
    }
    .lead-name{
        font-size:20px;
        font-weight:600;
        color:#2c2f32;
    }
    .lead-id{
        font-size:13px;
        font-weight:500;
        color:#727478;
    }
    .lead-header .badge {
        font-size: 13px !important;
        padding: 5px 10px;
        border-radius: 6px !important;
        margin-left: 10px;
    }
    .close-icon{
        position: absolute;
        right: 15px;
        top: 15px;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s;
        border-radius: 50% !important;
    }

    .close-icon:hover{
        background: #e4e4e4;
    }

    .close-icon img{
        width: 12px;
        height: 12px;
        object-fit: contain;
    }
   
    .lead-details{
        max-height: calc(90vh - 110px); /* space for header + close button */
        overflow-y: auto;
        padding: 20px 20px 0;
        margin: 5px 5px 5px 0;
        background: #FFFFFF;
    }

    /* Custom Scrollbar */
    .lead-details::-webkit-scrollbar{
        width: 6px;
    }
    .lead-details::-webkit-scrollbar-track{
        background: transparent;
        border-radius: 10px;
    }
   .lead-details::-webkit-scrollbar-thumb { 
        background: #b3b3b3; 
        border-radius: 10px; 
    } 
    .lead-details::-webkit-scrollbar-thumb:hover {
        background: #999999; 
    }
    .section-title{
        color: #1E293B;
        font-weight: 600;
        font-size:16px;
        margin: 0 0 12px;
    }
    .detail-grid{
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap:16px;
        margin-bottom: 20px;
    }
    .detail-box{
        display:flex;
        align-items:flex-start;
        gap:10px;
        border-radius: 6px !important;
        padding:12px;
        border: 0.593px solid #EBEEF2;
        background: #FFF;
        box-shadow: 0 0.564px 1.128px 0 rgba(0, 0, 0, 0.14);
    }
    .detail-box .icon {
        display: flex;
        min-width: 35px;
        height: 35px;
        align-items: center;
        justify-content: center;
        border-radius: 5px !important;
        background: rgba(233, 245, 253, 0.60);
    }
    .detail-box .icon img{
        width: 100%;
        height: 100%;
        max-width: 17px;
        max-height: 20px;
        object-fit: contain;
    }
    .detail-box .icon.industry img{
        max-width: 20px;
    }
    .detail-box .icon.category img{
        max-width: 18px;
    }
    .info-label{
        font-size:12px;
        color:#232425;
        font-weight:400;
    }
    .info-text{
        font-size:12px;
        font-weight:500;
        color:#1E293B;
        margin-top:2px;
        width: 212px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div class="lead-details-container">

    <!-- HEADER -->
    <div class="lead-header">
        <div class="lead-avatar">
            <?php echo strtoupper(substr($model->name,0,1)); ?>
        </div>
        <div>
            <div class="lead-name"><?php echo ucwords($model->name); ?></div>
            <div class="lead-id">ID: <?php echo $model->id; ?> 
           <?php if (!empty($model->status)) { 
                $status = trim($model->status);
                $displayStatus = $status;

                if ($status == "JunkLead") {
                    $displayStatus = "Junk Lead";
                } elseif ($status == "Avoided(No-Vendor)") {
                    $displayStatus = "No-Vendor";
                }

                $statusWords = explode(' ', $status);
                $firstWord = strtolower($statusWords[0]);
                $firstWordParts = explode('(', $firstWord);
                $firstWord = $firstWordParts[0];

                $badgeClass = "badge badge-" . $firstWord;
            ?>
                <span class="<?= $badgeClass; ?>">
                    <?= htmlspecialchars($displayStatus, ENT_QUOTES, 'UTF-8'); ?>
                </span>
            <?php } ?>
        </div>
        </div>
        <div class="close-icon" id="close_popup">
            <img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_close_i.svg">
        </div>
    </div>
    <div class="lead-details">
        <!-- CONTACT INFORMATION -->
        <h4 class="section-title">Contact Information</h4>
        <div class="detail-grid">

            <?php if(!empty($model->email)){ ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_mail_i.svg"></div>
                <div>
                    <div class="info-label">Email Address</div>
                    <div class="info-text" title="<?php echo $model->email; ?>"><?php echo $model->email; ?></div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($model->mobile)){ ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_phone_i.svg"></div>
                <div>
                    <div class="info-label">Contact</div>
                    <div class="info-text"><?php echo $model->countrycode .' '. $model->mobile; ?></div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($model->company)){ ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_company_i.svg"></div>
                <div>
                    <div class="info-label">Company</div>
                    <div class="info-text"><?php echo $model->company; ?></div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($model->designation)){ ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_designation_i.svg"></div>
                <div>
                    <div class="info-label">Designation</div>
                    <div class="info-text"><?php echo $model->designation; ?></div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($model->city)){ ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_city_i.svg"></div>
                <div>
                    <div class="info-label">City</div>
                    <div class="info-text"><?php echo $model->city; ?></div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($model->state)){ ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_state_i.svg"></div>
                <div>
                    <div class="info-label">State</div>
                    <div class="info-text"><?php echo $model->state; ?></div>
                </div>
            </div>
            <?php } ?>
            <?php if(!empty($model->ip_country)){ ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/total_revenue.svg"></div>
                <div>
                    <div class="info-label">Country</div>
                    <div class="info-text"><?php echo $model->ip_country; ?></div>
                </div>
            </div>
            <?php } ?>

        </div>


        <!-- LEAD DETAILS -->
        <h4 class="section-title">Lead Details</h4>
        <div class="detail-grid">

            <?php if(!empty($model->category_reference->name)){ ?>
            <div class="detail-box">
                <div class="icon category"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_category_i.svg"></div>
                <div>
                    <div class="info-label">Category</div>
                    <div class="info-text"><?php echo $model->category_reference->name;?></div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($model->industry)){ ?>
            <div class="detail-box">
                <div class="icon industry"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_industry_i.svg"></div>
                <div>
                    <div class="info-label">Industry</div>
                    <div class="info-text"><?php echo $model->industry; ?></div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($model->main_criteria_label) && !empty($model->main_criteria_units) && $model->main_criteria_label != 'NA'){ ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_number_of_employees_i.svg"></div>
                <div>
                    <div class="info-label"><?php echo $model->main_criteria_label; ?></div>
                    <div class="info-text"><?php echo $model->main_criteria_units; ?></div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($model->deployment)){ ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_deployment_i.svg"></div>
                <div>
                    <div class="info-label">Deployment</div>
                    <div class="info-text"><?php echo $model->deployment; ?></div>
                </div>
            </div>
            <?php } ?>

            <?php if(!empty($model->date)){ ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_calender_i.svg"></div>
                <div>
                    <div class="info-label">Submission Date</div>
                    <div class="info-text"><?php echo date('d-m-Y',strtotime($model->date)); ?></div>
                </div>
            </div>
            <?php } ?>

            <?php if (!empty($model->sell_live_on_date) && $model->sell_live_on_date !== "0000-00-00 00:00:00") { ?>
            <div class="detail-box">
                <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/lead_view_icon/lv_calender_i.svg"></div>
                <div>
                    <div class="info-label">Qualified Date</div>
                    <div class="info-text"><?php echo date('d-m-Y',strtotime($model->sell_live_on_date)); ?></div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
