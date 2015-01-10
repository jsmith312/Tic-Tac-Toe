SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL auto_increment,
  `game_state` varchar(128) NOT NULL,
  `current_player` varchar(128) default NULL,
  PRIMARY KEY  (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `moves` (
  `move_id` int(11) NOT NULL auto_increment,
  `game_id` int(11) NOT NULL,
  `player_id` varchar(128) NOT NULL,
  `position` int(1) NOT NULL,
  `move_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`move_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `players` (
  `player_id` varchar(128) NOT NULL,
  `name` varchar(1024) NOT NULL,
  PRIMARY KEY  (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `players_games` (
  `player_id` varchar(128) NOT NULL,
  `game_id` int(11) NOT NULL,
  `player_type` varchar(1) NOT NULL,
  `last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


SET FOREIGN_KEY_CHECKS = 1;
