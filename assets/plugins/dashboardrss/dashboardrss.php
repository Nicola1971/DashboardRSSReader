<?php
$urls[0] = $FeedUrl;

// How many items per Feed?
$itemsNumber = intval($rssitemsnumber);

$ThisRole = $ThisRole ?? '';
$ThisUser = $ThisUser ?? '';
$HeadBG = isset($HeadBG) ? trim($HeadBG) : '';
$HeadColor = isset($HeadColor) ? trim($HeadColor) : '';
$BodyBG = isset($BodyBG) ? trim($BodyBG) : '';
$BodyColor = isset($BodyColor) ? trim($BodyColor) : '';
$BodyHeight = isset($BodyHeight) ? trim($BodyHeight) : '200';

/* End of configuration
NO NEED TO EDIT BELOW THIS LINE
---------------------------------------------- */

if (!class_exists('SimplePie\SimplePie')) {
    require_once(MODX_MANAGER_PATH . 'media/rss/vendor/autoload.php');
}

$feed = new SimplePie\SimplePie();
$feedCache = MODX_BASE_PATH . 'assets/cache/rss';
if (!is_dir($feedCache)) {
    @mkdir($feedCache, intval($modx->getConfig('new_folder_permissions'), 8), true);
}
$feed->set_cache_location($feedCache);

$feedData = array();

// create Feed
foreach ($urls as $section=>$url) {
    $rssoutput = '';
    $feed->set_feed_url($url);
    $feed->init();
    $items = $feed->get_items(0, $itemsNumber);
    
    if(empty($items)) {
        $feedData[$section] = 'Failed to retrieve ' . $url;
        continue;
    }
    
    $rssoutput .= '<ul>';
    foreach ($items as $item) {
        $href = $item->get_link();
        $title = $item->get_title();
        $pubdate = $item->get_date();
        $pubdate = $modx->toDateFormat(strtotime($pubdate));
        $description = strip_tags($item->get_content());
        if (mb_strlen($description) > 300) {
            preg_match('/^\s*+(?:\S++\s*+){1,25}/u', $description, $matches);
            if (isset($matches[0]) && mb_strlen($description) !== mb_strlen($matches[0])) {
                $description = rtrim($matches[0]);
                $descriptionmore = '...<br />Read <a href="' . $href . '" target="_blank">more</a>.';
            }
            
        }
        
        $rssoutput .= '<li><a href="'.$href.'" target="_blank">'.$title.'</a> - <b>'.$pubdate.'</b><br />'.$description.' '.$descriptionmore.'</li>';
    }
    $rssoutput .= '</ul>';
    $feedData[$section] = $rssoutput;
}

// get manager role
$internalKey = $modx->getLoginUserID();
$sid = $modx->sid;
$role = $_SESSION['mgrRole'];
$user = $_SESSION['mgrShortname'];

// show widget only to Admin role 1
if(($role!=1) AND ($wdgVisibility == 'AdminOnly')) {}
// show widget to all manager users excluded Admin role 1
else if(($role==1) AND ($wdgVisibility == 'AdminExcluded')) {}
// show widget only to "this" role id
else if(($role!=$ThisRole) AND ($wdgVisibility == 'ThisRoleOnly')) {}
// show widget only to "this" username
else if(($user!=$ThisUser) AND ($wdgVisibility == 'ThisUserOnly')) {}
else {
    // get language
    global $modx,$_lang;
    // get plugin id
    $result = $modx->db->select('id', $this->getFullTableName("site_plugins"), "name='{$modx->event->activePlugin}' AND disabled=0");
    $pluginid = $modx->db->getValue($result);
    if($modx->hasPermission('edit_plugin')) {
        $button_pl_config = '<a data-toggle="tooltip" href="javascript:;" title="' . $_lang["settings_config"] . '" class="text-muted pull-right float-right" onclick="parent.modx.popup({url:\''. MODX_MANAGER_URL.'?a=102&id='.$pluginid.'&tab=1\',title1:\'' . $_lang["settings_config"] . '\',icon:\'fa-cog\',iframe:\'iframe\',selector2:\'#tabConfig\',position:\'center center\',width:\'80%\',height:\'80%\',hide:0,hover:0,overlay:1,overlayclose:1})" ><i class="fa fa-cog" style="color:'.$HeadColor.';"></i> </a>';
    }
    $modx->setPlaceholder('button_pl_config', $button_pl_config);
    
    //events
    $EvoEvent = isset($EvoEvent) ? $EvoEvent : 'OnManagerWelcomeHome';
    $output = "";
    $e = &$modx->Event;
    
    /*Widget Box */
    if($e->name == ''.$EvoEvent.'') {
        $widgets['DashboardRSS'] = array(
            'menuindex' =>''.$wdgposition.'',
            'id' => 'DashboardRSS'.$pluginid.'',
            'cols' => 'col-md-'.$wdgsizex.'',
            'cardAttr' => 'style="background-color:'.$BodyBG.'; color:'.$BodyColor.'; padding-bottom:0.5rem;"',
            'headAttr' => 'style="background-color:'.$HeadBG.'; color:'.$HeadColor.';"',
            'bodyAttr' => 'style="background-color:'.$BodyBG.'; color:'.$BodyColor.'; max-height:'.$BodyHeight.'px;overflow-y: scroll; padding:0;"',
            'icon' => ''.$wdgicon.'',
            'title' => ''.$wdgTitle.' '.$button_pl_config.'',
            'body' => '<div class="card-body">'.$feedData[$section].'</div>',
            'hide' => '0'
        );	
        $e->output(serialize($widgets));
    }
    if($e->name == 'OnManagerWelcomePrerender') {
    $cssout ='
    <style>
    #DashboardRSS'.$pluginid.' .card-body {padding-top:0;}
    #DashboardRSS'.$pluginid.' .card-block ul {padding:0; margin:0;}
    #DashboardRSS'.$pluginid.' .card-block ul li, #DashboardRSS'.$pluginid.' .card-block ul li {
    padding: 0.75rem 0.2rem;
    border-bottom: 1px solid #ebebeb;
    }
    </style>
    ';
    $e->output($cssout);
    }
}
?>