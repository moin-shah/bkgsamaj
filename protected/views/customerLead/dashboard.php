<div class="page-content-inner dashboard">
  <div class="section">
    <div class="summary-header">
      <h2 class="d-title">Summary</h2>
      <div class="cu-date-picker">
        <input type="text" id="daterange" name="daterange" placeholder="Select Date Range" autocomplete="off"/>
        <i class="fa fa-calendar" aria-hidden="true"></i>
      </div>
    </div>
    <div class="summary-cards">
      <a class="summary-card" href="<?=Yii::app()->createAbsoluteUrl('/' . ltrim(Yii::app()->user->partner_slug . '/myleads'));?>" data-title="Total Leads">
        <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/total_leads.svg" alt="Total Leads"></div>
        <div class="text">
          <h3 id='lead_total'><?= $lead_data['total'] ?></h3>
          <div class="summary-card-title">
            <p>Total Leads</p> 
              <div class="info">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <span class="details">Total number of leads received from all sources.</span>
              </div>
          </div>
        </div>
      </a>
      <a class="summary-card" href="<?=Yii::app()->createAbsoluteUrl('/' . ltrim(Yii::app()->user->partner_slug . '/myleads'));?>?lead_type=verified"  data-title="Verified Leads">
        <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/verified_leads.svg" alt="Verified Leads"></div>
        <div class="text">
          <h3 id='verified_lead_total'><?= $lead_data['verified'] ?></h3>
          <div class="summary-card-title">
            <p>Verified Leads</p> 
              <div class="info">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <span class="details">Total number of leads that have been verified for accuracy through validation checks.</span>
              </div>
          </div>
        </div>
      </a>
      <a class="summary-card" href="<?=Yii::app()->createAbsoluteUrl('/' . ltrim(Yii::app()->user->partner_slug . '/myleads'));?>?lead_type=qualified"  data-title="Qualified Leads">
        <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/qualified_leads.svg" alt="Qualified Leads"></div>
        <div class="text">
          <h3 id='qualified_lead_total' ><?= $lead_data['qualified'] ?></h3>
          <div class="summary-card-title">
            <p>Qualified Leads</p> 
              <div class="info">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <span class="details">Total number of leads that meet the qualification criteria for sales or follow-up.</span>
              </div>
          </div>
        </div>
      </a>
      <div class="summary-card revenue-card">
        <div class="icon"><img src="<?=Yii::app()->baseUrl?>/images/total_revenue.svg" alt="Total Revenue"></div>
        <div class="text">
          <h3><span class="currency-symbol">$</span><span id="revenue_inr"><?= $lead_data['revenue_inr'] ?></span><span id="revenue_usd"><?= $lead_data['revenue_usd'] ?></span></h3>
          <div class="summary-card-title">
            <p>Total Revenue</p> 
              <div class="info">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                <span class="details">Total revenue generated from all qualified leads. Revenue figures update 15 days after the lead is shared.</span>
              </div>
          </div>
          <div class="exchange-rate"><img src="<?=Yii::app()->baseUrl?>/images/low_to_high.svg" alt="convertion rate">1 USD = <?=Yii::app()->user->conversion_rate?> INR</div>
        </div>
        <div class="currency-toggle">
          <button class="toggle-btn active" data-currency="usd">$</button>
          <button class="toggle-btn" data-currency="inr">₹</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats & Insights Grid -->
  <div class="dashboard-grid">
    <!-- Stats -->
    <div class="grid-left">
      <div class="section">
        <h2 class="d-title">Stats</h2>
        <div class="chart-box">
          <canvas id="myChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Insights -->
    <div class="grid-right">
      <div class="section">
        <h2 class="d-title">Insights</h2>
        <table class="insights-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Leads</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($stats_arr as $date => $lead_count) { ?>
              <tr>
              <td><?= date('M j, Y', strtotime($date));?></td>
              <td><?= $lead_count;?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
  $('input[name="daterange"]').daterangepicker({
    "opens": "left",
    minDate: "<?=$start_date?>",
    maxDate: moment(),
    startDate: "<?=$start_date?>",
    endDate: moment(),
    locale: {
      format: 'MMM DD, YYYY',
      cancelLabel: 'Clear'  
    }
  });

  $('.cu-date-picker i').on('click', function () {
    $('input[name="daterange"]').trigger('click');
  });

  const ctx = document.getElementById('myChart');
  const dataValues = [<?=$lead_counts?>];
  const maxValue = Math.max(...dataValues);
  let stepSize, suggestedMax;

  if (maxValue <= 5) {
    stepSize = 1;
    suggestedMax = 5;
  } else {
    function getNiceStep(max) {
      const range = max / 6;
      const magnitude = Math.pow(10, Math.floor(Math.log10(range)));
      const residual = range / magnitude;

      let niceFraction;
      if (residual <= 1) niceFraction = 1;
      else if (residual <= 2) niceFraction = 2;
      else if (residual <= 5) niceFraction = 5;
      else niceFraction = 10;

      return niceFraction * magnitude;
    }

    stepSize = getNiceStep(maxValue);
    stepSize = Math.max(1, Math.ceil(stepSize));
    suggestedMax = Math.ceil(maxValue / stepSize) * stepSize;
  }

  const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [<?=$label_string?>],
      datasets: [{
        data: dataValues,
        backgroundColor: '#4A75BC',
        hoverBackgroundColor: '#4A75BC',
        borderRadius: { topLeft: 8, topRight: 8 },
        borderSkipped: false,
        barThickness: 55
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      layout: { padding: { right: 25 } },
      animation: { duration: 1200, easing: 'easeOutQuart' },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#ffffff',
          titleColor: '#000000',
          bodyColor: '#000000',
          padding: 14,
          cornerRadius: 8,
          displayColors: false,
          boxPadding: 6,
          titleFont: { weight: 'normal' },
          callbacks: {
            label: function (context) {
              const value = context.raw;
              const suffix = value <= 1 ? 'Lead' : 'Leads';
              return value + ' ' + suffix;
            }
          }
        },
        tooltipShadow: { enabled: true },
        datalabels: {
          color: '#FFFFFF',
          anchor: 'center',
          align: 'center',
          offset: -8,
          font: { weight: '500', size: 12 },
          formatter: (value) => value
        }
      },
      scales: {
        x: {
          grid: { display: false, drawBorder: false },
          ticks: { color: '#6B7280', font: { size: 12 } }
        },
        y: {
          beginAtZero: true,
          grid: { color: '#EEF0F4', drawBorder: false, borderDash: [10, 10] },
          border: { display: false },
          ticks: {
            color: '#6B7280',
            font: { size: 12 },
            stepSize: stepSize
          },
          suggestedMax: suggestedMax
        }
      }
    },
    plugins: [
      ChartDataLabels,
      {
        id: 'tooltipShadow',
        afterDraw(chart) {
          const tooltip = chart.tooltip;
          if (!tooltip || tooltip.opacity === 0) return;

          const ctx = chart.ctx;
          ctx.save();
          ctx.shadowColor = 'rgba(0,0,0,0.18)';
          ctx.shadowBlur = 12;
          ctx.shadowOffsetX = 2;
          ctx.shadowOffsetY = 4;
          tooltip.draw(ctx);
          ctx.restore();
        }
      }
    ]
  });

  document.getElementById('myChart').addEventListener('mousemove', function (event) {
    const points = myChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);
    if (points.length) {
      const index = points[0].index;
      $('.insights-table tbody tr').removeClass('highlighted');
      $('.insights-table tbody tr').eq(index).addClass('highlighted');
    } else {
      $('.insights-table tbody tr').removeClass('highlighted');
    }
  });

  $('.insights-table tbody tr').each(function (index) {
    $(this).on('mouseenter', function () {
      const meta = myChart.getDatasetMeta(0);
      myChart.setActiveElements([{ datasetIndex: 0, index }]);
      myChart.tooltip.setActiveElements([{ datasetIndex: 0, index }], { x: 0, y: 0 });
      myChart.update();
    });

    $(this).on('mouseleave', function () {
      myChart.setActiveElements([]);
      myChart.tooltip.setActiveElements([], { x: 0, y: 0 });
      myChart.update();
    });
  });

  const usdBtn = document.querySelector('.toggle-btn[data-currency="usd"]');
  const inrBtn = document.querySelector('.toggle-btn[data-currency="inr"]');
  const currencyToggle = document.querySelector('.currency-toggle');

  const revenueUsd = document.getElementById('revenue_usd');
  const revenueInr = document.getElementById('revenue_inr');
  const currencySymbol = document.querySelector('.currency-symbol');

  function setCurrency(isUSD) {
    if (isUSD) {
      usdBtn.classList.add('active');
      inrBtn.classList.remove('active');
      currencySymbol.textContent = '$';
      revenueUsd.style.display = 'inline';
      revenueInr.style.display = 'none';
    } else {
      inrBtn.classList.add('active');
      usdBtn.classList.remove('active');
      currencySymbol.textContent = '₹';
      revenueUsd.style.display = 'none';
      revenueInr.style.display = 'inline';
    }
  }

  currencyToggle.addEventListener('click', () => {
    const isUSDActive = usdBtn.classList.contains('active');
    setCurrency(!isUSDActive);
  });


  var partner_slug = '<?= $partner_slug ?>';
  var partner_source = '<?= $partner_source ?>';
  var lead_count_url='<?php echo Yii::app()->request->getBaseUrl(true);?>/index.php?r=customerLead/getleadcounts';
  
  // Function to make AJAX call
  function getLeadCounts(partner_source, daterange = '') {
      $.ajax({
          url: lead_count_url,
          type: 'POST',
          dataType: 'json',
          data: {
              daterange: daterange,
              partner_source: partner_source
          },
          success: function(response) {
              $('#lead_total').text(response.total ?? 0);
              $('#verified_lead_total').text(response.verified ?? 0);
              $('#qualified_lead_total').text(response.qualified ?? 0);
              $('#revenue_inr').text(response.revenue_inr ?? 0);
              $('#revenue_usd').text(response.revenue_usd ?? 0);
          },
          error: function() {
              alert('Error loading data.');
          }
      });
  }

  $(document).ready(function() {
    // On filter button click
     $('#daterange').on('change', function() {
        const daterange = $('#daterange').val();
        getLeadCounts(partner_source, daterange);
  
        const formattedRange = formatDateRange(daterange);
        const baseUrls = document.querySelectorAll('.summary-card[href]');
        baseUrls.forEach(link => {
          const url = new URL(link.href);
          if (formattedRange) {
            url.searchParams.set('date_range', formattedRange);
          } else {
            url.searchParams.delete('date_range');
          }
          link.href = url.toString();
        });
      });

    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev,picker) {
      picker.setStartDate(moment());
      picker.setEndDate(moment()); 
      $(this).val('');
      getLeadCounts(partner_source);

      const baseUrls = document.querySelectorAll('.summary-card[href]');
      baseUrls.forEach(link => {
        const url = new URL(link.href);
        url.searchParams.delete('date_range');
        link.href = url.toString();
      });
    });

    function formatDateRange(range) {
      if (!range) return '';
      const dates = range.split(' - ');
      if (dates.length !== 2) return '';

      const startDate = moment(dates[0].trim(), 'MMM DD YYYY').format('YYYY-MM-DD');
      const endDate = moment(dates[1].trim(), 'MMM DD YYYY').format('YYYY-MM-DD');

      return `${startDate}_${endDate}`;
    }
  });
</script>