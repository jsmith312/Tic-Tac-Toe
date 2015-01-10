<?php
/******************************************************************************
 * ttt_lib.php
 *
 * This file contains all the database calls you will need to implement in
 * order to complete the API Server. Do not include any SQL statements in your
 * main ttt.php file.
 *
 * Skeletons of all of my functions are provided for you. If you find the
 * need to create additional functions, go right ahead. I do not claim to have
 * the only, or best, solution for this API Server.  :)
 *****************************************************************************/

/**
 * getDB
 *
 * Gets a reference to the global database connection. If none exists yet, one is created.
 */ 
function getDB() {
  global $tttdb;
  
  if (empty($tttdb)) {
    // create a new PDO database connection, and store it in the global $tttdb variable
  }
  
  return $tttdb;
}

/**
 * dbQuery
 *
 * A basic utility functino for performing SQL calls to our database. The SQL statement in $sql
 * is executed directly if no $params array is passed in.  If a $params array is passed in, then
 * a new PDO Prepared Statement is created from the $sql, and executed with the $params array.
 * @param $sql - A string containing the SQL statement to execute.
 * @param $params - an Array containing statement substitutions to replace ? placeholders in $sql
 *                  see: http://php.net/manual/en/pdo.prepared-statements.php
 */ 
function dbQuery($sql, $params = NULL) {
  $db = getDB();
  if (empty($params)) {
    $result = $db->query($sql);
  } else {
    $result = $db->prepare($sql);
    $result->execute($params);
  }
  
  if ($result === false) {
    return false;
  }
  
  // Get all the results from our Database call as an array of Objects.
  $results = $result->fetchAll(PDO::FETCH_CLASS, "StdClass");

  // Return our object result
  return $results;
}

/**
 * dbLastInsertID
 *
 * Get the last auto-incriment ID generated as the result of an INSERT statement.
 * This will be useful when creating new games so that the ID of the newly created 
 * game can be referenced in subsequent database commands, as well as returned to the
 * user.
 */ 
function dbLastInsertID() {
  $db = getDB();
  $stmt = $db->query("SELECT LAST_INSERT_ID()");
  $lastId = $stmt->fetch();
  $lastId = $lastId[0];
  return $lastId;
}

/**
 * dbAddPlayer
 *
 * Add a new player to the player table.
 * @param $playerID - A string containing a unique playerID hash.
 */
function dbAddPlayer($playerID) {
  // Check to see if the player exists first
  // If they do, don't do anything
  // Otherwise, add the new player to the players table.
  // There's a field for name, but it is not used at this point, so just insert the player_id 
}

/**
 * dbGetPlayer
 *
 * Retrieve a player from the player table.
 * @param $playerID - A string containing a playerID.
 */
function dbGetPlayer($playerID) {
  // Select a player from the players table.
  // If one is found return just the single player object, not an array of one element.
  // If no player is found, return null
}

/**
 * dbGetGames
 *
 * Retrieve a list of games from the games table.
 * @param $type - An optional string containing a game type.
 *                Valid types for the game_state field are:
 *                   'open', 'playing', 'complete', and 'ended'
 */
function dbGetGames($type = "") {
  // Select the appropriate games, and return them as an array of objects.
}

/**
 * dbNewGame
 *
 * Create a new game, and add the given player ID to it. Return the newly created Game ID.
 * @param $playerID - A string containing a playerID.
 */
function dbNewGame($playerID) {
  // Create a new game and get its ID
  // Add the player to this game
  // Return the game ID
}

/**
 * dbGetCurrentGameID
 *
 * Get the ID of the most recent game a player has participated in.
 * @param $playerID - A string containing a playerID.
 */
function dbGetCurrentGameID($playerID) {
  // Get all game IDs a player has participated in
  // Return only the most recent game ID.
}

/**
 * dbGetGame
 *
 * Get a game object based on the privided gamd ID.
 * @param $gameID - An integer containing a gameID.
 */
function dbGetGame($gameID) {
  // Select the game from the games table
  // Return a single game object.
}

/**
 * dbUpdateGameState
 *
 * Update the game_state field for a given game.
 * @param $game - A game object, as returned from dbGetGame.
 */
function dbUpdateGameState($game) {
  // Update the game_state field of the games table for the provided $game->game_id based on the
  // newly updated $game->game_state property.
}

/**
 * dbGetPlayersForGame
 *
 * Update the game_state field for a given game.
 * @param $gameID - An integer containing a gameID.
 */
function dbGetPlayersForGame($gameID) {
  // Select all players from the players_games table for the given game ID
  // Return an array of players_games objects.
}

/**
 * dbAddPlayerToGame
 *
 * Add a player ID to the provided game ID.
 * @param $gameID - An integer containing a gameID.
 */
function dbAddPlayerToGame($playerID, $gameID) {
  // Make sure the given Game ID exists.
  // If the game ID exists, add a new record to the players_games table with the provided 
  //   player ID and game ID.
}

/**
 * dbUpdatePlayerGame
 *
 * Update an entry in the players_games table with new values from the provided player object.
 * @param $player - An object containing players_game data from dbGetPlayersForGame.
 */
function dbUpdatePlayerGame($player) {
  // Update a row in players_games
}

/**
 * dbGetMovesForGame
 *
 * Get all moves for a game.
 * @param $gameID - An integer containing a gameID.
 */
function dbGetMovesForGame($gameID) {
  // Get all moves from the 'moves' table for a given game ID
  // If any moves are found, return them as an array of moves objects.
  // If nothing is found, return null
}

/**
 * dbNewMove
 *
 * Add a new move to the moves table.
 * @param $game - A game object
 * @param $position - An integer containing the position of the move
 */
function dbNewMove($game, $position) {
  // Insert a new row into the moves table containing the game ID, current player ID, and position
}

/**
 * http_response_code
 *
 * The http_response_code function is present in PHP 5.4 and up, but not before.  Here is a 
 * basic implementation of the function that mirrors the functionality of http_response_code
 * provided in PHP 5.4 and above.  It tests for the existance of the function first, and will
 * only define it if it is not found.
 */
if (!function_exists('http_response_code')) {
    function http_response_code($code = NULL) {

        if ($code !== NULL) {

            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Bad Request'; break;
                case 401: $text = 'Unauthorized'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Forbidden'; break;
                case 404: $text = 'Not Found'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'Not Acceptable'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
            }

            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

            header($protocol . ' ' . $code . ' ' . $text);

            $GLOBALS['http_response_code'] = $code;

        } else {

            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

        }

        return $code;

    }
}