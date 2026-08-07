<div class="page-content-inner static-page">
    <div class="section">
        <div class="row margin-bottom-10">
            <div class="col-md-12">
                <div class="page-head">
                    <h2 class="page-title revenue-title info-wrapper">Revenue Estimator
                        <div class="info">
                            <i class="fa fa-info" aria-hidden="true"></i>
                            <span class="details"><b>Revenue Potential by Category</b> - Explore the minimum and maximum lead or click value for each category across India and GCC to understand potential revenue opportunities.</span>
                        </div>
                    </h2>    
                    <div class="c-toggle-container">
                        <label for="countryToggle" class="c-toggle-label">India</label>
                        <label class="c-switch">
                            <input type="checkbox" id="countryToggle">
                            <span class="c-slider"></span>
                        </label>
                        <label for="countryToggle" class="c-toggle-label">GCC</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning" role="alert">
                    * Displayed rates are estimated and subject to change. Actual rates may vary based on market dynamics and campaign performance.
                </div>
            </div>
        </div>

        <!-- India Table -->
        <div class="row table-section" id="indiaTable">
            <div class="col-md-12">
                <div class="grid-view">
                    <table>
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th class="text-center">CPL - Min Price</th>
                                <th class="text-center">CPL - Max Price</th>
                                <th class="text-center">CPC Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($indiaData as $item) { ?>
                                <tr>
                                    <td><?= $item['category']; ?></td>
                                    <td class="text-center"><?= $item['min']; ?></td>
                                    <td class="text-center"><?= $item['max']; ?></td>
                                    <td class="text-center"><?= $item['price_per_click']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- GCC Table -->
        <div class="row table-section" id="gccTable" style="display:none;">
            <div class="col-md-12">
                <div class="grid-view">
                    <table>
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th class="text-center">CPL - Min Price</th>
                                <th class="text-center">CPL - Max Price</th>
                                <th class="text-center">CPC Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gccData as $item) { ?>
                                <tr>
                                    <td><?= $item['category']; ?></td>
                                    <td class="text-center"><?= $item['min']; ?></td>
                                    <td class="text-center"><?= $item['max']; ?></td>
                                    <td class="text-center"><?= $item['price_per_click']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   $(window).on('load', function () {
    if ($.fn.uniform && $('#uniform-countryToggle').length) {
      $.uniform.restore('#countryToggle');
    }

    $('#countryToggle').on('change', function() {
        const indiaLabel = $('.c-toggle-label').first();
        const gccLabel = $('.c-toggle-label').last();

        if ($(this).is(':checked')) {
            $('#indiaTable').hide();
            $('#gccTable').fadeIn(0);

            gccLabel.addClass('active');
            indiaLabel.removeClass('active');
        } else {
            $('#gccTable').hide();
            $('#indiaTable').fadeIn(0);

            indiaLabel.addClass('active');
            gccLabel.removeClass('active');
        }
    });
    $('.c-toggle-label').first().addClass('active');
});

</script>