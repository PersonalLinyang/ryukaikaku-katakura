<?php
get_header();

$limit = 20;
$page = 1;
if(array_key_exists('page', $_GET) && is_numeric($_GET['page'])) {
  $page = intval($_GET['page']);
}
$offset = ($page - 1) * $limit;
$pager_around = 2;

$sql_select = "SELECT tb_notification.ID AS id, tb_notification.post_title AS title, tb_notification.post_name AS slug, tb_start_date.meta_value AS date ";
$sql_count = "SELECT count(tb_notification.ID) count_total ";
$sql_base = "FROM wp_posts AS tb_notification "
          . "LEFT JOIN (SELECT post_id, meta_value FROM wp_postmeta WHERE meta_key='notification_date') AS tb_start_date "
              . "ON tb_notification.ID = tb_start_date.post_id "
          . "LEFT JOIN (SELECT post_id, meta_value FROM wp_postmeta WHERE meta_key='notification_end_date') AS tb_end_date "
              . "ON tb_notification.ID = tb_end_date.post_id "
          . "WHERE tb_notification.post_type='notification' "
              . "AND tb_notification.post_status='publish' "
              . "AND tb_start_date.meta_value<='" . date('Ymd') . "' "
              . "AND (tb_end_date.meta_value>='" . date('Ymd') . "' OR tb_end_date.meta_value='') ";
$sql_after = "ORDER BY tb_start_date.meta_value DESC, tb_notification.ID DESC "
           . "LIMIT " . $limit . " OFFSET " . $offset;

$notifications = $wpdb->get_results($sql_select . $sql_base . $sql_after);
$total_count = $wpdb->get_var($sql_count . $sql_base);
$page_count = intval(ceil($total_count / $limit));

if($page > $page_count) :
  get_template_part( 'template-parts/404' );
else:

?>

<section class="notification-topic">
  <p class="topic-en">NOTIFICATION</p>
  <h2 class="topic-jp">お知らせ</h2>
</section>

<section class="breadcrumb">
  <ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
      <a itemprop="item" href="<?php echo get_site_url(); ?>/">
        <span itemprop="name">ホーム</span>
      </a>
      <meta itemprop="position" content="1" />
    </li>
    
    <li class="breadcrumb-item">お知らせ</li>
  </ol>
</section>

<section class="notification-area">
  <ul class="notification-list">
    <?php 
    foreach($notifications as $notification): 
      $notification_type = get_field('notification_type', $notification->id);
      $notification_title = '';
      if($notification->title) {
        $notification_title = $notification->title;
      } else {
        switch($notification_type['value']) {
          case 'holiday':
            $holiday_start_date = get_field('notification_holiday_startdate', $notification->id);
            $holiday_end_date = get_field('notification_holiday_enddate', $notification->id);
            if($holiday_start_date == $holiday_end_date) {
              $notification_title = $holiday_start_date . 'に臨時休暇についてお知らせ';
            } else {
              $notification_title = $holiday_start_date . 'から' . $holiday_end_date . 'までに臨時休暇についてお知らせ';
            }
            break;
          case 'newmenu':
          case 'limitedmenu':
            if($notification_type['value'] == 'newmenu') {
              $notification_title = '新品料理';
            } else {
              $notification_title = '期間限定メニュー';
            }
            $notification_menu_list = get_field('notification_menu', $notification->id);
            $counter = 0;
            foreach($notification_menu_list as $index => $notification_menu) {
              if($counter == 2) {
                $notification_title .= 'などが';
                break;
              } else if($counter > 0) {
                $notification_title .= '、';
              }
              $notification_title .= '「' . $notification_menu->post_title . '」';
              $counter++;
            }
            $notification_title .= '絶賛登場!!';
            break;
          default:
            $notification_title = 'お知らせ';
        }
      }
    ?>
      <li class="notification-item">
        <div class="notification-info">
          <p class="notification-date"><?php echo date('Y-m-d', strtotime($notification->date)); ?></p>
          <p class="notification-tag notification-tag-<?php echo $notification_type['value']; ?>"><?php echo $notification_type['label']; ?></p>
        </div>
        <p class="notification-title"><a href="<?php echo get_site_url(); ?>/notification/<?php echo $notification->slug; ?>/"><?php echo $notification_title; ?></a></p>
      </li>
    <?php endforeach; ?>
  </ul>
  <p class="notification-count">合計 <?php echo $total_count; ?> 件中 <?php echo ($offset + 1); ?> ～ <?php echo ($offset + count($notifications)); ?> 件を表示</p>
</section>

<?php if($page_count > 1): ?>
  <section class="notification-pager">
    <ul class="notification-pager-list">
      <?php if($page > 1): ?>
        <li class="notification-pager-item wider-item has-link">
          <a class="full-link" href="<?php echo get_site_url(); ?>/notification/">最初へ</a>
        </li>
        <li class="notification-pager-item wide-item has-link">
          <a class="full-link" href="<?php echo get_site_url(); ?>/notification/<?php echo ($page > 2) ? ('?page=' . ($page - 1)) : ''; ?>">前へ</a>
        </li>
      <?php endif; ?>
      
      <?php if(($page - $pager_around) > 1): ?>
        <li class="notification-pager-item">...</li>
      <?php endif; ?>
      
      <?php for($counter = max(1, ($page - $pager_around)); $counter < $page; $counter++): ?>
        <li class="notification-pager-item has-link">
          <a class="full-link" href="<?php echo get_site_url(); ?>/notification/<?php echo ($counter > 1) ? ('?page=' . $counter) : ''; ?>"><?php echo $counter; ?></a>
        </li>
      <?php endfor; ?>
      
      <li class="notification-pager-item current-item"><?php echo $page; ?></li>
      
      <?php for($counter = $page + 1; $counter <= min($page_count, ($page + $pager_around)); $counter++): ?>
        <li class="notification-pager-item has-link">
          <a class="full-link" href="<?php echo get_site_url(); ?>/notification/?page=<?php echo $counter; ?>"><?php echo $counter; ?></a>
        </li>
      <?php endfor; ?>
      
      <?php if(($page + $pager_around) < $page_count): ?>
        <li class="notification-pager-item">...</li>
      <?php endif; ?>
      
      <?php if($page < $page_count): ?>
        <li class="notification-pager-item wide-item has-link">
          <a class="full-link" href="<?php echo get_site_url(); ?>/notification/?page=<?php echo ($page + 1); ?>">次へ</a>
        </li>
        <li class="notification-pager-item wider-item has-link">
          <a class="full-link" href="<?php echo get_site_url(); ?>/notification/?page=<?php echo $page_count; ?>">最後へ</a>
        </li>
      <?php endif; ?>
    </ul>
  </section>
<?php endif; ?>

<?php
endif;

get_footer();
