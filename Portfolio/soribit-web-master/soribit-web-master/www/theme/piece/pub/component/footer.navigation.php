<?php
$get_banner_or_ad = getBannerOrAd();
?>
<div class="banner">
    <div class="banner_slide">
        <?php foreach ($get_banner_or_ad as $iValue) { ?>
            <a href="outlink:<?php echo $iValue['gotoUrl']?>" target="_blank" class="item" style="background-image: url(<?php echo $iValue['src']?>"></a>
        <?php } ?>
    </div>
</div>
