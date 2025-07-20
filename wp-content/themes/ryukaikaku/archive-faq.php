<?php
get_header();

global $wpdb;

// FAQ取得SQL
$sql_faq = "SELECT tb_faq.ID AS faq_id, tb_wtt.term_id AS faqc_id "
         . "FROM (SELECT ID FROM wp_posts WHERE post_type='faq' and post_status='publish') AS tb_faq "
         . "LEFT JOIN wp_term_relationships AS tb_wtr ON tb_faq.ID = tb_wtr.object_id "
         . "LEFT JOIN wp_term_taxonomy AS tb_wtt ON tb_wtr.term_taxonomy_id = tb_wtt.term_taxonomy_id "
         . "LEFT JOIN (SELECT post_id, meta_value FROM wp_postmeta WHERE meta_key='faq_sort') AS tb_faq_sort ON tb_faq_sort.post_id = tb_faq.ID "
         . "LEFT JOIN (SELECT term_id, meta_value FROM wp_termmeta WHERE meta_key='faqc_sort') AS tb_faqc_sort ON tb_faqc_sort.term_id = tb_wtt.term_id "
         . "ORDER BY tb_faqc_sort.meta_value ASC, "
         . "tb_wtt.term_id ASC, "
         . "tb_faq_sort.meta_value ASC, "
         . "tb_faq.ID ASC ";

// SQL実行
$rows_faq = $wpdb->get_results($sql_faq);

//FAQリスト整理
$faqc_list = array();
foreach($rows_faq as $row) {
  if(!in_array($row->faqc_id, array_keys($faqc_list))) {
    $faqc = get_term($row->faqc_id, 'faq_category');
    if($faqc) {
      $faqc_list[$row->faqc_id] = array(
        'name' => $faqc->name,
        'faq_list' => array(),
      );
    } else {
      continue;
    }
  }
  array_push($faqc_list[$row->faqc_id]['faq_list'], $row->faq_id);
}
?>

<section class="faq-topic">
  <p class="topic-en">FAQ</p>
  <h2 class="topic-jp">よくある質問</h2>
</section>

<section class="breadcrumb">
  <ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?php echo get_site_url(); ?>/">
        <span itemprop="name">ホーム</span>
      </a>
      <meta itemprop="position" content="1" />
    </li>
    
    <li class="breadcrumb-item">よくある質問</li>
  </ol>
</section>

<section class="faq-navi">
  <ul class="faq-navi-list">
    <?php foreach($faqc_list as $faqc_id => $faqc_info): ?>
    <li class="title-font faq-navi-item"><a href="#faqc<?php echo $faqc_id; ?>"><?php echo $faqc_info['name']; ?></a></li>
    <?php endforeach; ?>
  </ul>
</section>

<?php foreach($faqc_list as $faqc_id => $faqc_info): ?>
  <section class="faq-content" id="faqc<?php echo $faqc_id; ?>">
    <h3 class="title-font faq-content-title"><?php echo $faqc_info['name']; ?></h3>
    <ul class="faq-content-list">
      <?php foreach($faqc_info['faq_list'] as $faq_id): ?>
      <li class="faq-content-item">
        <p class="title-font faq-content-item-question active"><?php echo get_the_title($faq_id); ?></p>
        <div class="faq-content-item-answer"><?php echo get_field('faq_answer', $faq_id); ?></div>
      </li>
      <?php endforeach; ?>
    </ul>
  </section>
<?php endforeach; ?>

<?php
get_footer();
