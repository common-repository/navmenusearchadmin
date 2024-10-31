<?php

/**
 * The Class
 */
class nMSA_searchClass {

  const LANG = 'exch_lang';

  public static function init() {
    $class = __CLASS__;
    new $class;
  }

  public function __construct() {
        // Abort if not on the nav-menus.php admin UI page - avoid adding elsewhere
    global $pagenow;
    if (!is_admin() || 'nav-menus.php' !== $pagenow)
      return;

    $this->add_search_custom_meta_box();
  }

    /**
     * Adds the meta box container
     */
    public function add_search_custom_meta_box() {
      add_meta_box(
        'info_meta_box_'
        , __('Empty', self::LANG)
        , array($this, 'add_search_ber_top')
                , 'nav-menus' // important !!!
                , 'side' // important, only side seems to work!!!
                , 'low'
                );
    }

    /**
     * 
     */
    public function add_search_ber_top() {
      $all_menu = $this->get_all_menu_list();
      $ids = array_column($all_menu, 'term_id');
      $ids = array_values($ids);
      $names = array_column($all_menu, 'name');
      $names = array_values($names);      
      $mixedup = array_combine($names,$ids);
      $names =json_encode($names);
      $mixedup =json_encode($mixedup);
      $baseurl = admin_url();

      $searchbar = '<input id="searchmenufield" value="" placeholder="Start Typing for auto suggession..." /><input type="button" onclick="link2menu()" value="Select">';

      $makeJSlocation = <<<EOD
      <script>
       jQuery('.wrap h1').append('<div id="menusearch"> $searchbar</div>');

       jQuery( function() {
        var availableTags =$names;
        jQuery( "#searchmenufield" ).autocomplete({
          source: availableTags
        });
      } );
      jQuery('.ui-autocomplete').on('click', function() {
        alert( this.value );
      })

      function link2menu()
      {
        var  mixedup=$mixedup;

        var current_menu =jQuery('#searchmenufield').val(); 
        if(current_menu!='')
        {
         var baseUrl ='$baseurl';

         var pagelink = baseUrl+"nav-menus.php?action=edit&menu="+mixedup[current_menu];
         window.location.href =pagelink;

       }
     }

   </script>

EOD;

   echo $makeJSlocation;
 }

 private function get_all_menu_list() {
   $all_menu=wp_get_nav_menus();
   $count =0;
   foreach ($all_menu as &$value) {
    $value = (array)$value; 
  }
  return $all_menu;
}

}
