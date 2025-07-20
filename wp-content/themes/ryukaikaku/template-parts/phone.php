<?php 

$phone_key = '';
if(in_array('phone_key', array_keys($args))) {
  $phone_key = $args['phone_key'];
}

?>
<p class="phone <?php echo $phone_key; ?>">
  <a class="full-link phone-link <?php echo $phone_key; ?>-link" href="tel:0454915127">
    <svg class="phone-fill">
      <defs>
        <linearGradient id="<?php echo $phone_key; ?>-gradient" x1="0" x2="1" y1="0" y2="1">
          <stop offset="0%" class="phone-fill-stop1" />
          <stop offset="100%" class="phone-fill-stop2" />
        </linearGradient>
      </defs>
    </svg>
    <svg class="phone-icon <?php echo $phone_key; ?>-icon" style="fill: url(#<?php echo $phone_key; ?>-gradient);">
      <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/svg/phone-icon.svg#phone-icon"></use>
    </svg>
    <span class="phone-number <?php echo $phone_key; ?>-number">045-491-5127</span>
  </a>
</p>