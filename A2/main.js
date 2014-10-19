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
    'ball_radius': 5,
    'ball_color': '#FFF',
    'bg_color': '#000',
    'current_x': 0,
    'current_y': 0, 
    'paddle_x': 0,
    'paddle_y': 0,
    'paddle_width': 100,
    'paddle_height': 10,
    'bricks': undefined,
    'b_rows': 8,
    'b_cols': 10,
    'brick_width': 40,
    'brick_height': 10,
    'brick_padding': 0,
    'bricks_hits': 0,
    'bricks_left': 0,
    'canvas_width': 0, 
    'canvas_height': 0,
    'game_speed': 10,
    'speed_increase': 9/10,
    'points': 0,
    'level': 1,
    'turns_left': 3
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
    game_config.paddle_x = c.pageX - (game_config.paddle_width / 2);
}

window.addEventListener('resize', resizeCanvas, false);

function init(){
    var canvas = document.getElementById('brickbreaker');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    
    paint_bg();

    write_points();

    game_config.canvas_width = canvas.width;
    game_config.canvas_height = canvas.height;

    game_config.current_x = (game_config.canvas_width / 2) - (game_config.ball_radius / 2);
    game_config.current_y = game_config.canvas_height - game_config.paddle_height - 20;
    
    game_config.paddle_x = (game_config.canvas_width / 2) - (game_config.paddle_width / 2);
    game_config.paddle_y = canvas.height - game_config.paddle_height - 10;

    game_config.brick_width = (canvas.width/game_config.b_cols) - game_config.brick_padding;

    game_config.bricks_left = game_config.b_rows * game_config.b_cols;

    init_bricks();
    
    draw_bricks();
    draw_ball();
    draw_paddle();
    
    canvas.addEventListener('click', brickLoop, false);
}

function write_points() {
    var canvas = document.getElementById('brickbreaker');
    var ctx = canvas.getContext('2d');

    ctx.font = '20px Courier';
    ctx.fillStyle = "#FFF";
    ctx.fillText('points: ' + game_config.points, 5, canvas.height - 10);
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

function create_brick(x, y, w, h, color) {
  var canvas = document.getElementById('brickbreaker');
  var ctx = canvas.getContext('2d');      
  ctx.beginPath();
  ctx.rect(x,y,w,h);
  ctx.fillStyle = color;
  ctx.closePath();
  ctx.fill();
}

function draw_bricks(){

    var color;
    //draw bricks
    for (i=0; i < game_config.b_rows; i++) {
        for (j=0; j < game_config.b_cols; j++) {
            if (bricks[i][j] == 1) {

                if(i >= 0 && i < 2) {
                    color = '#F00';//red
                }
                else if(i >= 2 && i < 4) {
                    color = '#FFA500';//orange
                }
                else if(i >= 4 && i < 6) {
                    color = '#0F0';//green
                }
                else {
                    color = '#FF0';//yellow
                }
            }
            else
                color = '#000';

                create_brick((j * (game_config.brick_width + game_config.brick_padding)) + game_config.brick_padding, 
                     (i * (game_config.brick_height + game_config.brick_padding)) + game_config.brick_padding,
                     game_config.brick_width, game_config.brick_height, color);
            
            

          
        }
    }
}

function paint_bg() {
    canvas = document.getElementById('brickbreaker');
    ctx = canvas.getContext('2d');

    ctx.beginPath();
    ctx.rect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = game_config.bg_color;
    ctx.closePath();
    ctx.fill();
}

function clear_canvas() {
    var canvas = document.getElementById('brickbreaker');
    var ctx = canvas.getContext('2d');    
    ctx.clearRect(0, 0, game_config.canvas_width, game_config.canvas_height);
}

function moveBall(){
    clear_canvas();
    paint_bg();
    write_points();
    draw_bricks();

    rowheight = game_config.brick_height + game_config.brick_padding;
    colwidth = game_config.brick_width + game_config.brick_padding;
    
    row = Math.floor(game_config.current_y/rowheight);
    col = Math.floor(game_config.current_x/colwidth);

    // Collision detection
    if (game_config.current_y < game_config.b_rows * rowheight && row >= 0 && col >= 0 && bricks[row][col] === 1) {

        if(row >= 0 && row < 2) {
            //red
            game_config.points += 7;
        }
        else if(row >= 2 && row < 4) {
            //orange
            game_config.points += 5;
        }
        else if(row >= 4 && row < 6) {
            //green
            game_config.points += 3;
        }
        else {
            //yellow
            game_config.points += 1;
        }

        game_config.bricks_left--;

        //if no bricks are left on the canvas, start the next level
        if(game_config.bricks_left === 0) {
            clearInterval(window.gameLoop);
            console.log("Next level!");//debugging
            game_config.b_cols = Math.floor(game_config.b_cols * 1.5); //increase the number of bricks
            console.log("# of bricks per row: " + game_config.b_cols);//debugging
            game_config.bricks_left = game_config.b_cols * game_config.b_rows;
            game_config.game_speed = game_config.game_speed * game_config.speed_increase;
            console.log("New speed: " + game_config.game_speed);//debugging
            init();
        }

        game_config.dy = -game_config.dy;
        bricks[row][col] = 0;
     }
    if (game_config.current_x + game_config.dx > game_config.canvas_width || game_config.current_x + game_config.dx < 0) {
        game_config.dx = -game_config.dx;
    } 

    if (game_config.current_y + game_config.dy < 0){
        game_config.dy = -game_config.dy;
    } 
    else if (game_config.current_y + game_config.dy > game_config.canvas_height - game_config.paddle_height - 10) {
        if (game_config.current_x > game_config.paddle_x && game_config.current_x < game_config.paddle_x + game_config.paddle_width)
          game_config.dy = -game_config.dy;
        else {//restart
          clearInterval(window.gameLoop);
          init();
        }
    }

    game_config.current_x += game_config.dx;
    game_config.current_y += game_config.dy;
    
    draw_ball();
    draw_paddle();
}

// Main game loop below;
function brickLoop(){
    
    console.log('Started Loop');
    
    var canvas = document.getElementById('brickbreaker');
    var ctx = canvas.getContext('2d');
    
    window.gameLoop = setInterval(moveBall, game_config.game_speed);

    
}