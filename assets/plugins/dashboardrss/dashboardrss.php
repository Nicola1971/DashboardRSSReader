<?php
/**
 * DashboardRSSReader RC 3.2.2
 * author Nicola Lambathakis http://www.tattoocms.it/
 *
 * RSS Dashboard widget plugin for Evolution cms
 * Event: OnManagerWelcomeHome
&wdgVisibility=Show widget for:;menu;All,AdminOnly,AdminExcluded,ThisRoleOnly,ThisUserOnly;All &ThisRole=Run only for this role:;string;;;(role id) &ThisUser=Run only for this user:;string;;;(username) &wdgTitle= Widget Title:;string;RSS Feed  &wdgicon= widget icon:;string;fa-rss-square  &wdgposition=widget position:;text;1 &wdgsizex=widget width:;list;12,6,4,3;12 &FeedUrl=Rss url:;string;http://feeds.feedburner.com/RecentCommitsToEvolutiondevelop &rssitemsnumber=Feed items number:;string;3 &WidgetID= Unique Widget ID:;string;RSS-widget &HeadBG= Widget Title Background color:;string; &HeadColor= Widget title color:;string; &BodyBG= Widget Body Background color:;string; &BodyColor= Widget Body text color:;string;
****
*/
// Run the main code
//include($modx->config['base_path'].'assets/plugins/welcomefeed/welcomefeed.php');


/* Configuration
---------------------------------------------- */
// Here you can set the urls to retrieve the RSS from. Simply add a $urls line following the numbering progress in the square brakets.

//$urls['http://www.ideefesta.it/rss.rss'] = $rss_url;

$urls[0] = $FeedUrl;

// How many items per Feed?
$itemsNumber = $rssitemsnumber;

/* End of configuration
NO NEED TO EDIT BELOW THIS LINE
---------------------------------------------- */

// include MagPieRSS
require_once('media/rss/rss_fetch.inc');

$feedData = array();

// create Feed
foreach ($urls as $section=>$url) {
	$rssoutput = '';
    $rss = @fetch_rss($url);
    if( !$rss ){
    	$feedData[$section] = 'Failed to retrieve ' . $url;
    	continue;
	}
    $rssoutput .= '<ul>';

    $items = array_slice($rss->items, 0, $itemsNumber);
    foreach ($items as $item) {
        $href = $item['link'];
        $title = $item['title'];
        $pubdate = $item['pubdate'];
        $pubdate = $modx->toDateFormat(strtotime($pubdate));
        $description = strip_tags($item['description']);
        if (strlen($description) > 199) {
            $description = substr($description, 0, 200);
            $description .= '...<br />Read <a href="'.$href.'" target="_blank">more</a>.';
        }
        $rssoutput .= '<li><a href="'.$href.'" target="_blank">'.$title.'</a> - <b>'.$pubdate.'</b><br />'.$description.'</li>';
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
$button_pl_config = '<a data-toggle="tooltip" href="javascript:;" title="' . $_lang["settings_config"] . '" class="text-muted pull-right" onclick="parent.modx.popup({url:\''. MODX_MANAGER_URL.'?a=102&id='.$pluginid.'&tab=1\',title1:\'' . $_lang["settings_config"] . '\',icon:\'fa-cog\',iframe:\'iframe\',selector2:\'#tabConfig\',position:\'center center\',width:\'80%\',height:\'80%\',hide:0,hover:0,overlay:1,overlayclose:1})" ><i class="fa fa-cog" style="color:'.$HeadColor.';"></i> </a>';
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
				'cardAttr' => 'style="background-color:'.$BodyBG.'; color:'.$BodyColor.';"',
                'headAttr' => 'style="background-color:'.$HeadBG.'; color:'.$HeadColor.';"',
				'bodyAttr' => 'style="background-color:'.$BodyBG.'; color:'.$BodyColor.';"',
				'icon' => ''.$wdgicon.'',
				'title' => ''.$wdgTitle.' '.$button_pl_config.'',
				'body' => '<div class="card-body">'.$feedData[$section].'</div>',
				'hide' => '0'
			);	
            $e->output(serialize($widgets));
}
}
?>
