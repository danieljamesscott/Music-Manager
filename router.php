<?php
/**
 * @package	Music
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @copyright	Copyright (C) 2009 Daniel Scott (http://danieljamesscott.org). All rights reserved.
 * @license	GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

function MusicBuildRoute(&$query) {
  $segments	= array();

  if (isset($query['view'])) {
    $segments[] = $query['view'];
    unset ($query['view']);
  }

  if (isset($query['cid'])) {
    $segments[] = $query['cid'];
    unset ($query['cid']);
  }

  if (isset($query['artist_id'])) {
    $segments[] = $query['artist_id'];
    unset ($query['artist_id']);
  }

  if (isset($query['album_id'])) {
    $segments[] = $query['album_id'];
    unset ($query['album_id']);
  }

  if (isset($query['song_id'])) {
    $segments[] = $query['song_id'];
    unset ($query['song_id']);
  }
  return $segments;
}

function MusicParseRoute($segments) {
  $vars	= array();

  $vars['view'] = $segments[0];
  switch($vars['view']) {
  case 'album':
    $vars['album_id'] = $segments[1];
    $vars['cid'] = $segments[1];
    break;
  case 'artist':
    $vars['artist_id'] = $segments[1];
    $vars['cid'] = $segments[1];
    break;
  }
  return $vars;
}
