DROP TABLE IF EXISTS #__music_artist;
DROP TABLE IF EXISTS #__music_album;
DROP TABLE IF EXISTS #__music_song;
DROP TABLE IF EXISTS #__music_artistalbums;
DROP TABLE IF EXISTS #__music_albumsongs;
DROP TABLE IF EXISTS #__music;

CREATE TABLE #__music_artist (
  id int(11) NOT NULL AUTO_INCREMENT,
  alias varchar(255) NOT NULL default '',
  name varchar(50) NOT NULL default '',
  picture varchar(200) default NULL,
  published tinyint(1) unsigned NOT NULL default '0',
  checked_out int(11) unsigned NOT NULL default '0',
  checked_out_time datetime NOT NULL default '0000-00-00 00:00:00',
  editor varchar(150) NOT NULL default '',
  ordering int(11) NOT NULL default '0',
  params text NOT NULL,
  access tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE #__music_album (
  id int(11) NOT NULL AUTO_INCREMENT,
  alias varchar(255) NOT NULL default '',
  name varchar(50) NOT NULL default '',
  creationyear int(11) NOT NULL,
  albumart_front varchar(100) default NULL,
  albumart_back varchar(100) default NULL,
  published tinyint(1) unsigned NOT NULL default '0',
  checked_out int(11) unsigned NOT NULL default '0',
  checked_out_time datetime NOT NULL default '0000-00-00 00:00:00',
  editor varchar(150) NOT NULL default '',
  ordering int(11) NOT NULL default '0',
  params text NOT NULL,
  user_id int(11) NOT NULL default '0',
  access tinyint(3) unsigned NOT NULL default '0',
  email_to varchar(60) default '',
  description text(500) default '',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE #__music_song (
  id int(11) NOT NULL AUTO_INCREMENT,
  alias varchar(255) NOT NULL default '',
  name varchar(50) NOT NULL default '',
  number int(11) NOT NULL,
  filename varchar(255) NOT NULL,
  published tinyint(1) unsigned NOT NULL default '0',
  checked_out int(11) unsigned NOT NULL default '0',
  checked_out_time datetime NOT NULL default '0000-00-00 00:00:00',
  editor varchar(150) NOT NULL default '',
  ordering int(11) NOT NULL default '0',
  params text NOT NULL,
  user_id int(11) NOT NULL default '0',
  access tinyint(3) unsigned NOT NULL default '0',
  email_to varchar(60) default '',
  description text(500) default '',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE #__music_artistalbums (
  id int(11) NOT NULL AUTO_INCREMENT,
  alias varchar(255) NOT NULL default '',
  artist_id int(11) NOT NULL,
  album_id int(11) NOT NULL,
  published tinyint(1) unsigned NOT NULL default '0',
  checked_out int(11) unsigned NOT NULL default '0',
  checked_out_time datetime NOT NULL default '0000-00-00 00:00:00',
  editor varchar(150) NOT NULL default '',
  ordering int(11) NOT NULL default '0',
  params text NOT NULL,
  access tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE #__music_albumsongs (
  id int(11) NOT NULL AUTO_INCREMENT,
  alias varchar(255) NOT NULL default '',
  album_id int(11) NOT NULL,
  song_id int(11) NOT NULL,
  published tinyint(1) unsigned NOT NULL default '0',
  checked_out int(11) unsigned NOT NULL default '0',
  checked_out_time datetime NOT NULL default '0000-00-00 00:00:00',
  editor varchar(150) NOT NULL default '',
  ordering int(11) NOT NULL default '0',
  params text NOT NULL,
  access tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO #__music_artist (id, alias, name) VALUES
  (1, 'testartist1', 'Test Artist 1'),
  (2, 'testartist2', 'Test Artist 2');

INSERT INTO #__music_album (id, alias, name, creationyear, albumart_front, albumart_back) VALUES
  (1, 'testalbum1', 'Test Album 1', 2009, 'albumart_front.jpg', 'albumart_back.jpg'),
  (2, 'testalbum2', 'Test Album 2', 2010, 'albumart_front.jpg', 'albumart_back.jpg'),
  (3, 'testalbum3', 'Test Album 3', 2011, 'albumart_front.jpg', 'albumart_back.jpg');

INSERT INTO #__music_song (id, alias, name, number, filename) VALUES
  (1, 'testsong1', 'Test Song 1', 1, 'Song1.mp3'),
  (2, 'testsong2', 'Test Song 2', 2, 'Song2.mp3'),
  (3, 'testsong3', 'Test Song 3', 3, 'Song3.mp3');

INSERT INTO #__music_artistalbums (artist_id, album_id) VALUES
  (1, 1),
  (1, 2),
  (2, 3);

INSERT INTO #__music_albumsongs (album_id, song_id) VALUES
  (1,1),
  (2,2),
  (3,3);

