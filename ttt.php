<?php
/******************************************************************************
 * ttt.php
 *
 * This file contains all the API Server code for our Tic-Tac-Toe application
 *
 * This file will be called via HTTP GET requests from the Front End Client.
 * A basic program flow is provided for you, but you are free to deviate 
 * from it as you need.
 *****************************************************************************/

require 'ttt_lib.php';
require 'nicejson.php';

// Start a PHP Session right away

// Get Command

// If no command is found, return an error

// If a command is found, but its not one of the allowed commands, return an error

// If we're processing any command OTHER than the 'login' command, check to make sure
// the user is currently logged in first.

// Process command
switch($command) {
  // Call various functions below based on the command given.
}

/**********************************************************
 **********************************************************
 * End of program flow. Functions only beyond this point.
 **********************************************************
 **********************************************************/

/**
 * getParam
 *
 * Utility function to get a property from the HTTP query string.
 */
function getParam($param) {
  if (isset($_GET[$param])) {
    return $_GET[$param];
  } else {
    doError("Param {$param} not set");
  }
}

/**
 * doLogin
 *
 * Log in a new player.  If they already have a current session, return the existing
 * player ID.
 */
function doLogin() {
  // Create a response object from StdClass()
  // See if the player is already logged in.  If they are, set the response message accordingly
  // If this is a new player, generate a unique player ID for them.
  // Try hashing their IP address along with the current timestamp or something.
  // Store the player ID in the current PHP session
  // Add the new player ID to the response
  // Return the response to the client
}


/**
 * doCheckLogin
 *
 * Check to make sure the user is currently logged in. If they are, don't do anything. 
 * If they're not logged in, return an error to the user.
 */
function doCheckLogin() {
  // Check the session to see if a player ID exists in the current PHP session
  // If not, call doError with the appropriate error message 
}


/**
 * doGetOpenGames
 *
 * Get a list of any games that are open but not started yet.
 */
function doGetOpenGames() {
  // Call dbGetGames to get open games
  // prepare a response message to return open games to the client
}


/**
 * doNewGame
 *
 * Create a new game and set it to 'open'. Add the current player as one of the participants. 
 */
function doNewGame() {
  // End any current games they might be part of
  // Start a new game and return the new game ID
}

/**
 * doJoinGame
 *
 * Join an existing game and start the game.
 */
function doJoinGame() {
  // End any current games they might be part of
  // Check if the game ID exists, return an error if it doesn't
  // If it does exist, make sure the game is open, and add them to the game
  // Start the game once the player has been added.
  // Create a response to send back with the new game state
}

/**
 * doEndGame
 *
 * End an existing game.
 */
function doEndGame($gameID) {
  // Get the current game state for a game ID, and set the game_state property to 'ended'
  // Update the game state.
}

/**
 * doMyGame
 *
 * Get the current game state for the current player's current game ID.
 */
function doMyGame() {
  // Get the current game ID for the logged in player
  // Get the current game state for the given game ID if found
  // Create a response to send to the player
}

/**
 * doGetMyGameID
 *
 * Return the Game ID associated with the current user.
 */
function doGetMyGameID() {
  // Get the current player ID from the session
  // Get the current game ID for this player from the database
  // Return the integer value for the game ID
}


/**
 * doStartGame
 *
 * Start a given game. Determine who's X and who's O, and set the game to 'playing'
 */
function doStartGame($gameID) {
  // Get the current game state for this game ID
  // Update Game State to 'playing'  
  // Randomly Assign X and O to the two players
  // Update each player with X or O depending on which one they are
}

/**
 * doGameState
 *
 * API Wrapper for getting the current state of a game
 */
function doGameState() {
  $gameID = getParam('gameID');
  $state = doGetGameState($gameID);

  $response = new StdClass();
  $response->message = "Game State for Game ID: {$gameID}";
  $response->data = $state;
  returnResponse($response, 200);
}


/**
 * doGetGameState
 *
 * Construct a current game state from various components.  
 * - Basic Game Data
 * - Players
 * - Moves
 * - Winner
 *
 * It also constructs a simple board representation of the moves as an array.
 */
function doGetGameState($gameID) {
  // Make sure a game ID is specified, if not, send an error to the client
  // Create a new $state object from StdClass();
  // Get basic game info for the game ID by calling dbGetGame and add their properties to the $state
  // Get all the players for this game, and add the result to the $state
  // Figure out who's X and O, and also which player is 'you'
  // Get all current moves and add the result to $state
  // Determine who's move it is, and assign that player to the $state->player_turn property
  // Build a game board array, and fill in each position based on the moves so far
  // See if there's a winner by calling doGameWinCheck($state), and assign the result to $state
  // Return the $state object you've constructed
}


/**
 * doMove
 *
 * Process a new move. Mostly make sure the move is valid, then save the move. Check to see
 * if the new move results in a win, and if so, update the game.
 */
function doMove() {
  // Get the game ID from the query string properties
  // Get the current game state for the game ID
  // Error if the game is still 'open'
  // Error if the game is 'complete'
  // Error if the game is 'closed'
  // Make sure its this person's turn
  // If it is our turn, see what position they chose, error if no position chosen
  // If the position isn't an int between 1 and 9 inclusive, its invalid
  // See if that position is already taken
  // Valid position, so record the new move in the database  
  // Update our local copy of the game state to reflect the newly inserted move
  // Check for a winner, if there's a winner, set the game as 'complete'
  // Create a response to send to the client
}


/**
 * doGameWinCheck
 *
 * Check to see if either player in a given game has won.
 * See: http://stackoverflow.com/questions/20578372/tictactoe-win-logic-for-nxn-board
 */
function doGameWinCheck($game) {
  $positionWeights = array(1, 2, 4, 8, 16, 32, 64, 128, 256);
  $winTotals = array(7, 56, 448, 73, 146, 292, 273, 84);
  
  foreach($game->players as $p) {
    $playerScore = 0;
    foreach($game->moves as $m) {
      if ($m->player_id != $p->player_id) {
        continue;
      }
      $position = $m->position;
      $positionScore = $positionWeights[$position-1];
      $playerScore += $positionScore;
    }

    foreach($winTotals as $w) {
      if (($w & $playerScore) == $w) {
        return $p;
      }
    }
  }
  
  return null;
}


/**
 * doError
 *
 * Construct an error response, and send it to the user.
 * @param $error - A text string containing the error to report
 * @param $code - The HTTP response code to use to report this error. Defaults to 400
 */
function doError($error, $code = 400) {
  $error = array("error" => $errorText);
  returnResponse($error, $code);
}


/**
 * returnResponse
 *
 * Return a JSON encoded response to the user.
 * @param $data - A data structure to encode as JSON and return.
 */
function returnResponse($data, $code) {
  // Encode the $data in JSON format
  // Call http_response_code with the provided HTTP response $code
  
  // Set an HTTP header with the correct JSON mime type

  // The following code ensures that Clients from other servers will be allowed to access our API.
  $referer = $_SERVER['HTTP_REFERER'];
  $urlParts = parse_url($referer);
  $accessHost = $urlParts['scheme'] . "://" . $urlParts['host'];
  header("Access-Control-Allow-Origin: {$accessHost}");
  header("Access-Control-Allow-Credentials: true");
  
  // Send our JSON response text to the client

  // Compelte execution
  exit;
}


