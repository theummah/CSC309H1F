/*
* Andrew Louis and Mohdhar Noor, CSC309 Assignment #2 
* BrickBreaker
* 
* No third party libraries will be used in this script.
*
*/

var game_config = {
    'dx': 3, // Pixel increments per second
    'dy': 4,
    'ball_radius': 15,
    'ball_color': 'blue',
    'current_x': 0,
    'current_y': 0, 
    'paddle_x': 0,
    'paddle_y': 0,
    'paddle_width': 300,
    'paddle_height': 25,
    'bricks': undefined,
    'b_rows': 5,
    'b_cols': 5,
    'brick_width': 40,
    'brick_height': 20,
    'brick_padding': 1,
    'canvas_width': 0, 
    'canvas_height': 0
};

function init_bricks() {

  game_config.brick_width = game_config.canvas_width/game_config.b_cols;

  bricks = new Array(game_config.b_rows);
  for (i=0; i < game_config.b_rows; i++) {
    bricks[i] = new Array(game_config.b_cols);
    for (j=0; j < game_config.b_cols; j++) {
      bricks[i][j] = 1;
    }
  }
}

var run_game = true;

// Modifying the size of the canvas to the size of the viewport on resizing.
function resizeCanvas(){
    var canvas = document.getElementById('brickbreaker');
    
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    
    brickLoop();   
}

window.onload = function(){
    init();   
}

window.onmousemove = function(c){
    game_config.paddle_x = c.pageX;
}

window.addEventListener('resize', resizeCanvas, false);

function init(){
    var canvas = document.getElementById('brickbreaker');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    game_config.current_x = canvas.width / 2;
    game_config.current_y = canvas.height / 2;
    
    game_config.canvas_width = canvas.width;
    game_config.canvas_height = canvas.height;
    
    game_config.paddle_x = canvas.width/2;
    game_config.paddle_y = canvas.height - game_config.paddle_height - 10;

    game_config.brick_width = (canvas.width/game_config.b_cols) - 1;
    
    init_bricks();
    
    draw_bricks();
    draw_ball();
    draw_paddle();
    
    canvas.addEventListener('click', brickLoop, false);
}

// Draws the ball at position x, y
function draw_ball(){
    var canvas = document.getElementById('brickbreaker');
    var ctx = canvas.getContext('2d'); 
    ctx.beginPath();
    ctx.arc(game_config.current_x, 
            game_config.current_y, 
            game_config.ball_radius, 
            0, 
            2 * Math.PI, 
            false);
    ctx.fillStyle = game_config.ball_color;
    ctx.fill();
}

function draw_paddle(){
    var canvas = document.getElementById('brickbreaker');
    var ctx = canvas.getContext('2d');    
    
    ctx.beginPath();
    ctx.rect(game_config.paddle_x,
             game_config.paddle_y,
             game_config.paddle_width,
             game_config.paddle_height);
    ctx.closePath();
    ctx.fill();   
}

function create_brick(x,y,w,h) {
  var canvas = document.getElementById('brickbreaker');
  var ctx = canvas.getContext('2d');      
  ctx.beginPath();
  ctx.rect(x,y,w,h);
  ctx.fillStyle = "red";
  ctx.closePath();
  ctx.fill();
}

function draw_bricks(){
      //draw bricks
      for (i=0; i < game_config.b_rows; i++) {
        for (j=0; j < game_config.b_cols; j++) {
          if (bricks[i][j] == 1) {
            create_brick((j * (game_config.brick_width + game_config.brick_padding)) + game_config.brick_padding, 
                 (i * (game_config.brick_height + game_config.brick_padding)) + game_config.brick_padding,
                 game_config.brick_width, game_config.brick_height);
          }
        }
      }
}

function clear_canvas() {
    var canvas = document.getElementById('brickbreaker');
    var ctx = canvas.getContext('2d');    
    ctx.clearRect(0, 0, game_config.canvas_width, game_config.canvas_height);
}

function moveBall(){
    clear_canvas();
    draw_bricks();

    rowheight = game_config.brick_height + game_config.brick_padding;
    colwidth = game_config.brick_width + game_config.brick_padding;
    
    row = Math.floor(game_config.current_y/rowheight);
    col = Math.floor(game_config.current_x/colwidth);

    // Collision detection
    if (game_config.current_y < game_config.b_rows * rowheight && row >= 0 && col >= 0 && bricks[row][col] == 1) {
        game_config.dy = -game_config.dy;
        bricks[row][col] = 0;
    }
     
    if (game_config.current_x + game_config.dx > game_config.canvas_width || game_config.current_x + game_config.dx < 0){
        game_config.dx = -game_config.dx;
    } 
    if (game_config.current_y + game_config.dy < 0){
        game_config.dy = -game_config.dy;
    } 
    else if (game_config.current_y + game_config.dy > game_config.canvas_height - game_config.paddle_height - 10) {
        if (game_config.current_x > game_config.paddle_x && game_config.current_x < game_config.paddle_x + game_config.paddle_width)
          game_config.dy = -game_config.dy;
        else
          clearInterval(window.gameLoop);
    }
    
    game_config.current_x += game_config.dx;
    game_config.current_y += game_config.dy;    
    
    draw_ball();
    draw_paddle();
}

// Main game loop below;
function brickLoop(){
    
    console.log("Started Loop");
    
    var canvas = document.getElementById('brickbreaker');
    var ctx = canvas.getContext('2d');
    
    window.gameLoop = setInterval(moveBall, 10);

    
}   