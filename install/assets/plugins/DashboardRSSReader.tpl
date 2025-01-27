//<?php
/**
 * DashboardRSSReader
 *
 * Dashboard RSS widget for Evolution CMS
 *
 * @author    Nicola Lambathakis http://www.tattoocms.it
 * @category    plugin
 * @version    3.3
 * @license	 http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @events OnManagerWelcomeHome,OnManagerWelcomePrerender
 * @internal    @installset base
 * @internal    @modx_category Dashboard
 * @internal    @properties  &wdgVisibility=Show widget for:;menu;All,AdminOnly,AdminExcluded,ThisRoleOnly,ThisUserOnly;All &ThisRole=Run only for this role:;string;;;(role id) &ThisUser=Run only for this user:;string;;;(username) &wdgTitle= Widget Title:;string;RSS Feed  &wdgicon= widget icon:;string;fa-rss-square  &wdgposition=widget position:;text;1 &wdgsizex=widget width:;list;12,6,4,3;6 &FeedUrl=Rss url:;string;https://feeds.feedburner.com/tattoocms/extras &rssitemsnumber=Feed items number:;string;10 &WidgetID= Unique Widget ID:;string;RSS-widget &HeadBG= Widget Title Background color:;string; &HeadColor= Widget title color:;string; &BodyBG= Widget Body Background color:;string; &BodyColor= Widget Body text color:;string; &BodyHeight= Widget Body max-height:;string;300
 */

// Run the main code
include($modx->config['base_path'].'assets/plugins/dashboardrss/dashboardrss.php');