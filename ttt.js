var playerID;
var gameID;
var currentGame;
var newGameButton;
var leaveGameButton;
var openGamesDiv;

var waiting = ['Other player is thinking, Oh the suspense!', 
'Other players turn ... I think he said somethin\' nasty \'bout cha', 
'Oh man, get ready this guy\'s crazy!'];

var turn = ['Your turn, sonny', 'Get at \'em!', 'Make my day'];

var randWaiting = waiting[Math.floor(Math.random() * waiting.length)];

var randTurn = turn[Math.floor(Math.random() * turn.length)];

/*********************************************************************
 * Load Event Listener
 * This will run once the page has loaded, and will setup our behaviors
 ****************************************************************************/
window.addEventListener('load', function() {
  login();
});

// Log in to the API
function login() {
  // Here's an example of how to call our simple ajax() wrapper function. You'll use this a lot.
  ajax("cmd=login", gotLogin);
}

function gotLogin(response) {
  // get player id
  player = response.playerid;
  // grab message
  mess = response.message;
  // Update the message field with the message from this response
  updateMessage(mess);
  // Display the player ID on the game board
  document.getElementById("playerid").innerHTML = player;
  // Store the player ID in our global playerID variable for later use
  playerID = player;
  // Finish setup
  setup();
}

function setup() {
  position = document.getElementsByClassName("position");
  newGames = document.getElementById("newGame");
  // Add a click event handler to all the position TD elements on the board
  positionClick('click');
  // Add a click event handler to the new game button
  newGames.addEventListener('click', function() {
    newGame();
  });
  // See if we're part of a game already by making 
  // an ajax call to the myGame command, and handling the result
  ajax('cmd=myGame', gotMyGame);
  // See if there are any existing games by making 
  // an ajax call to the getGames command, and handling the result
  ajax('cmd=getGames', gotOpenGames);
  // Start a board refresh timer with a two second 
  // interval (2000ms), set refreshBoardTimer as the callback
  setTimeout(refreshBoardTimer, 2000);
}

function gotMyGame(response) {
  if (response.data != null )
  {
    // See if we got a game state from our response
    currentGame = response.data.game_state;
    // If the game_state property is 'open', display a 
    // message saying we're waiting for another player to join.
    if (currentGame === 'open')  
    {
      document.getElementById("currentGame").innerHTML = 'Waiting for another player to join ... ';
    } 
      // If the game_state is set to 'playing' or 'complete', 
      // update the game board state by calling updateGameState()
    if (currentGame === 'playing' || currentGame === 'complete')  {
      updateGameState(response);
    }
  } 
}

// Handle Open Games Response
function gotOpenGames(response) {
  // remove all existing game nodes from the #openGames div
  openGamesDiv = document.getElementById('openGames');  
  while (openGamesDiv.firstChild) {
    openGamesDiv.removeChild(openGamesDiv.firstChild);
  }
  // Add new elements to the #openGames div 
  // for each game reported in the response.
    for (i = 0; i < response.data.length; i++) {
      var para = document.createElement("div");
      var ID = response.data[i].game_id
      var node = document.createTextNode(ID);
      para.className +='game-id';
      // Make each new element respond to a 'click' 
      // event, and set joinGame as a callback.
      para.addEventListener('click', joinGame, false);
      para.appendChild(node);
      openGamesDiv.appendChild(para);
  } 
}

// Callback function for the click event on the new game button.
function newGame() {
  // Send an AJAX command to create a new game
  ajax('cmd=newGame', newGameResult);
}

function newGameResult(response) {
  // remove all existing game nodes from the #openGames div
  openGamesDiv = document.getElementById('openGames');  
  while (openGamesDiv.firstChild) {
    openGamesDiv.removeChild(openGamesDiv.firstChild);
  }
  // Handle the display of any information from the response to our newGame command
  mess = response.message;
  gameID = response.gameID;
  // Clear the board
  for (i = 1; i < 10 ; i++ ) {
      document.getElementById("position"+i).style.backgroundImage="";
      document.getElementById("currentGameIMG").style.backgroundImage="";
  }
  updateMessage(mess);
}

// Event handler attached to each game to join
function joinGame() {
  // Send a new AJAX command to join the given 
  // gameID, and set joinGameResult as the callback
  ajax('cmd=joinGame&gameID='+this.textContent, joinGameResult);
}

// Handle the response from joining a game
function joinGameResult(response) {
  // remove all existing game nodes from the #openGames div
  while (openGamesDiv.firstChild) {
    openGamesDiv.removeChild(openGamesDiv.firstChild);
  }
  mess = response.message;
  for (i = 1; i < 10 ; i++ ) {
      document.getElementById("position"+i).style.backgroundImage="";
      document.getElementById("currentGameIMG").style.backgroundImage="";
  }
  // Store the game ID in our global gameID variable for later use.
  gameID = response.data.game_id;
  // Update the message field with the new message from this response.
  updateMessage(mess);
}

// Event handler attached to teach TD position element.
function positionClick(event) {
  // Send a new AJAX command to record a new move. Pass gotMoveResult as the callback
  getAttr = function() {
      data_pos = this.getAttribute("data-position");
      ajax('cmd=move&gameID='+gameID+'&position='+data_pos, gotMoveResult);
  };
  for(var i = 0; i < position.length; i++) {
    position[i].addEventListener(event, getAttr, false);
  }
}

// Handle result from a move
function gotMoveResult(response) {
  mess = response.message;
  // Update the message field
  updateMessage(mess);
  // Update the game board with the new game state returned

}

// Update the game board with a given game state
function updateGameState(game) {
  board = game.data.board;
  winner = game.data.winner;

  //updateMessage(currentGame);
  // Update each position on the Board
  if (currentGame === 'playing' || currentGame === 'complete') {
    for (i = 1; i < 10 ; i++ ) {
      if (board[i] == 'X'){
        document.getElementById("position"+i).style.backgroundImage="url('X.png')";
        document.getElementById("position"+i).style.backgroundSize = "125px";

      }
      if (board[i] == 'O') {
        document.getElementById("position"+i).style.backgroundImage="url('O.png')";
        document.getElementById("position"+i).style.backgroundSize = "125px";
      }
    }
    // Are you X or O?
    if (game.data.you.player_type == 'X') { 
      document.getElementById("currentGame").innerHTML = 'You are ';
      document.getElementById("currentGameIMG").style.backgroundImage="url('x2.png')";
      document.getElementById("currentGameIMG").style.backgroundSize = "30px";
    }
    if (game.data.you.player_type == 'O') { 
      document.getElementById("currentGame").innerHTML = 'You are ';
      document.getElementById("currentGameIMG").style.backgroundImage="url('o2.png')";
      document.getElementById("currentGameIMG").style.backgroundSize="30px";
    }
    // Who's turn is it?
    if (game.data.player_turn.player_id === playerID) {
      updateMessage(randTurn);
    } else {
      updateMessage(randWaiting);
    }
  }
  if (currentGame === 'complete') {
    if (game.data.winner.player_id === playerID) {
        updateMessage('Congrats you won!');
    }
    if (game.data.winner.player_id != playerID) {
        updateMessage('Sorry, you lost!');
    }
  }
} 


// Callback from our refresh timeout
function refreshBoardTimer() {
  // Send a new AJAX call for myGame, set gotMyGame as the callback
  ajax('cmd=myGame', gotMyGame);
  // Send a new AJAX call for getGames, set gotOpenGames as the callback
  ajax('cmd=getGames', gotOpenGames);
  // Set a new timeout for 2 seconds with refreshBoardTimer as the callback again
  setTimeout(refreshBoardTimer, 2000);
}

// Update the message text on the screen
function updateMessage(text) {
  // Update the #messages element with the new text
  document.getElementById("messages").innerHTML = text;
}

// A basic wrapper for our AJAX Calls.
// It takes a full URL to call, along with a callback function on completion.
function ajax(cmd, callback) {
  // Change the base URL here if you're targeting someone else's API Server
  url = "http://ttt.workbench.uits.arizona.edu/ttt.php?" + cmd;
  // Attach a random seed to the end of the URL to avoid browser caching.
  url = url + "&seed=" + (new Date()).getTime();
  var xmlhttp;
  if (window.XMLHttpRequest) 
  { // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
    xmlhttp.withCredentials = true;
  }
  else 
  { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.withCredentials = true;
  }
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      var response = JSON.parse(xmlhttp.responseText);
      callback(response);
    }
  }
  xmlhttp.open("GET", url, true);
  xmlhttp.send();
}
