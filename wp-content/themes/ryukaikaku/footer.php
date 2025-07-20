<?php
/*
 * フッタ部分
 */

$menu_categories = get_terms(array('taxonomy'=>'menu_category', 'get'=>'all')); 

?>

    </main>
    
    <footer class="footer">
      <div class="footer-inner">
        <div class="footer-content">
          
          <div class="footer-info">
            <?php get_template_part('template-parts/logo', null, array('logo_key' => 'footer-logo')); ?>
            
            <div class="footer-info-address">
              <p class="footer-info-zipcode">&#12306;&nbsp;221-0865</p>
              <p>神奈川県横浜市神奈川区<br/>片倉２丁目６９−１５</p>
            </div>
            
            <?php get_template_part('template-parts/phone', null, array('phone_key' => 'footer-phone')); ?>
          </div>
          
          <div class="footer-map">
            
            <div class="footer-map-menu">
              <p class="footer-map-title footer-map-menu-title">メニュー</p>
              <div class="footer-map-list">
                <?php foreach($menu_categories as $menu_category): ?>
                  <li class="footer-map-item">
                    <a href="<?php echo get_site_url(); ?>/menu/<?php echo $menu_category->slug; ?>/">
                      <?php echo $menu_category->name; ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </div>
            </div>
            
            <div class="footer-map-info">
              <p class="footer-map-title"><a href="<?php echo get_site_url(); ?>/menu/notification/">お知らせ</a></p>
              <p class="footer-map-title"><a href="<?php echo get_site_url(); ?>/menu/faq/">よくある質問</a></p>
              <p class="footer-map-title"><a href="<?php echo get_site_url(); ?>/menu/about/">店舗案内</a></p>
            </div>
            
          </div>
          
        </div>
      </div>
    </footer>

    <?php wp_footer(); ?>
  </body>
</html>
