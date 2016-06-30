<?php $package_data = $this->Format->get_subscription_plans(); ?>

<div class="pro-chart">
    <?php
    $counter = 0;
    $line1 = '';
    $line2 = '';
    $line3 = '';
    $line4 = '';
    $line5 = '';
    $line6 = '';
    $line7 = '';
    $line8 = '';
    $line9 = '';
    $line10 = '';
    $line11 = '';
    $line12 = '';
    $line13 = '';
    $line14 = '';
    $line15 = '';
    $line16 = '';
    $header_color_array = array('#009746', '#BDCF17', '#89CCD0', '#FABD3E', '#F3953E');
    $header_width_array = array('14%', '16%', '16%', '16%', '16%');
    foreach ($package_data as $k => $v) {
        $package_class = strtolower($this->Format->seo_url($v['Package']['name'])) . " common_class";
        $line1 .= '<th class="' . $package_class . '" style="background:' . $header_color_array[$counter] . ';width:' . $header_width_array[$counter] . ';" id="package_header_' . $counter . '">' . $v['Package']['name'] . '</th>';
        $line2 .= '<td class="' . $package_class . '"><i class="fa fa-inr"></i>&nbsp;&nbsp;' . $v['Package']['price'] . " p.m." . '</td>';
        $line3 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['priority_search'], 'boolean') . '</td>';
        $line4 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['personal_subdomain'], 'boolean') . '</td>';
        $line5 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['social_media_widget'], 'boolean') . '</td>';
        $line6 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['map_integration'], 'boolean') . '</td>';
        $line7 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['photo_limit'], 'string') . '</td>';
        $line8 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['video_limit'], 'string') . '</td>';
        $line9 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['subscription'], 'string') . '</td>';
        $line10 .= '<td class="' . $package_class . '">' . $v['Package']['listing_period'] . "  days" . '</td>';
        $line11 .= '<td class="' . $package_class . '">' . $v['Package']['payment_method'] . '</td>';
        $line12 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['enquiries']) . '</td>';
        $line13 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['address_detail']) . '</td>';
        $line14 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['call_request']) . '</td>';
        $line15 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['review']) . '</td>';
        $line16 .= '<td class="' . $package_class . '">' . $this->Format->formatPackage($v['Package']['faq']) . '</td>';
        $counter++;
    }
    echo '<table cellpadding="0" cellspacing="0" class="pricing-table">     
            <tr><th style="background:#E53424;width:22%;">Features</th>' . $line1 . '</tr>
            <tr><td style="font-weight:bold">Price</td> ' . $line2 . '</tr>
            <tr><td style="font-weight:bold">Priority Search</td>' . $line3 . '</tr>
            <tr><td style="font-weight:bold">Personal sub-domain</td>' . $line4 . '</tr>
            <tr><td style="font-weight:bold">Social Media Widget</td>' . $line5 . '</tr>
            <tr><td style="font-weight:bold">Google Map integration</td>' . $line6 . '</tr>
            <tr><td style="font-weight:bold">Photos Upload</td>' . $line7 . '</tr>
            <tr><td style="font-weight:bold">Videos Upload</td>' . $line8 . '</tr>
            <tr><td style="font-weight:bold">Subscriptions</td>' . $line9 . '</tr>
            <tr><td style="font-weight:bold">Listing Period</td>' . $line10 . '</tr>
            <tr><td style="font-weight:bold">Payment method</td>' . $line11 . '</tr>
            <tr><td style="font-weight:bold">Enquiries submission</td>' . $line12 . '</tr>
            <tr><td style="font-weight:bold">Address details</td>' . $line13 . '</tr>
            <tr><td style="font-weight:bold">Request a Call</td>' . $line14 . '</tr>
            <tr><td style="font-weight:bold">Reviews</td>' . $line15 . '</tr>
            <tr><td style="font-weight:bold">FAQs</td>' . $line16 . '</tr>
    </table>';
    ?>

</div>