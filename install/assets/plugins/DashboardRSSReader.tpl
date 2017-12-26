//<?php
/**
 * DashboardRSSReader
 *
 * Dashboard RSS widget for Evo 1.4
 *
 * @author    Nicola Lambathakis http://www.tattoocms.it
 * @category    plugin
 * @version    3.2.2 RC
 * @license	 http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @events OnManagerWelcomeHome
 * @internal    @installset base
 * @internal    @modx_category Dashboard
 * @internal    @properties  &wdgVisibility=Show widget for:;menu;All,AdminOnly,AdminExcluded,ThisRoleOnly,ThisUserOnly;All &ThisRole=Run only for this role:;string;;;(role id) &ThisUser=Run only for this user:;string;;;(username) &wdgTitle= Widget Title:;string;RSS Feed  &wdgicon= widget icon:;string;fa-rss-square  &wdgposition=widget position:;text;1 &wdgsizex=widget width:;list;12,6,4,3;12 &FeedUrl=Rss url:;string;http://feeds.feedburner.com/RecentCommitsToEvolutiondevelop &rssitemsnumber=Feed items number:;string;5 &WidgetID= Unique Widget ID:;string;RSS-widget &HeadBG= Widget Title Background color:;string; &HeadColor= Widget title color:;string; &BodyBG= Widget Body Background color:;string; &BodyColor= Widget Body text color:;string;
 */

/******
DashboardRSSReader 3.2.2 RC
OnManagerWelcomeHome

&wdgVisibility=Show widget for:;menu;All,AdminOnly,AdminExcluded,ThisRoleOnly,ThisUserOnly;All &ThisRole=Run only for this role:;string;;;(role id) &ThisUser=Run only for this user:;string;;;(username) &wdgTitle= Widget Title:;string;RSS Feed  &wdgicon= widget icon:;string;fa-rss-square  &wdgposition=widget position:;text;1 &wdgsizex=widget width:;list;12,6,4,3;12 &FeedUrl=Rss url:;string;http://feeds.feedburner.com/RecentCommitsToEvolutiondevelop &rssitemsnumber=Feed items number:;string;5 &WidgetID= Unique Widget ID:;string;RSS-widget &HeadBG= Widget Title Background color:;string; &HeadColor= Widget title color:;string; &BodyBG= Widget Body Background color:;string; &BodyColor= Widget Body text color:;string;
****
*/
// Run the main code
include($modx->config['base_path'].'assets/plugins/dashboardrss/dashboardrss.php');