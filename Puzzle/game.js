const DEFAULT_COLS = 4;
const DEFAULT_ROWS = 4;
const SHUFFLE_AMOUNT = 300;
const DEFAULT_IMAGE = 0;
const DEFAULT_WIDTH = 1850;

var columns = DEFAULT_COLS;
var rows = DEFAULT_ROWS;
var shuffling = SHUFFLE_AMOUNT;
var choice = DEFAULT_IMAGE;
var canvas = document.getElementById("myCanvas");
var ctx = canvas.getContext("2d");
var gallery = document.getElementById("gallery")
var colsInput = document.getElementById("columns");
var rowsInput = document.getElementById("rows");
var confirm = document.getElementById("confirm");
var reset = document.getElementById("reset");
var previous = document.getElementById("previous");
var next = document.getElementById("next");
var colsVal = document.getElementById("rangeCol");
var rowsVal = document.getElementById("rangeRow");
var sources = ["jeden.jpg", "dwa.jpg", "trzy.jpg", "cztery.jpg", "pięć.jpg", "sześć.jpg", "siedem.jpg", "osiem.jpg", "dziewięć.jpg", "dziesięć.jpg", "jedenaście.jpg", "dwanaście.jpg"]
var compresedSources = ["jeden_optimized.jpg", "dwa_optimized.jpg", "trzy_optimized.jpg", "cztery_optimized.jpg", "pięć_optimized.jpg", "sześć_optimized.jpg", "siedem_optimized.jpg", "osiem_optimized.jpg", "dziewięć_optimized.jpg", "dziesięć_optimized.jpg", "jedenaście_optimized.jpg", "dwanaście_optimized.jpg", ]
var img;
var pieces;
var shuffledElements;
var pieceHeight;
var pieceWidth;
var elementWidth;
var elementHeight;
var currentPiece;
var currentLightedPiece;
var redPiece;
var mouse;
var touch;

function init() {
    setCanvas();
    smallGallery();
    fullGallery();
    window.onresize = resizePuzzle;
    confirm.onclick = click;
    reset.onclick = resetClick;
    previous.onclick = prev;
    next.onclick = nxt;
    colsInput.onchange = changeCols;
    rowsInput.onchange = changeRows;
    img = new Image();
    img.setAttribute("src", "jeden.jpg");
    img.onload = setImage;
}

function resizePuzzle() {
    if (window.innerWidth < 1000) {
        canvas.width = gallery.width;
    } else {
        canvas.width = 1.7 * gallery.width;
    }
    canvas.height = 0.8 * window.innerHeight;
    pieceHeight = canvas.height / rows;
    pieceWidth = canvas.width / columns;
    elementHeight = img.height / rows;
    elementWidth = img.width / columns;
    var piece;
    for (i = 0; i < pieces.length; i++) {
        piece = pieces[i];
        if (piece == redPiece) {
            redPiece.xPos = piece.xRow * pieceWidth;
            redPiece.yPos = piece.yRow * pieceHeight;
        }
        piece.xPos = piece.xRow * pieceWidth;
        piece.yPos = piece.yRow * pieceHeight;

    }
    draw();
}

function smallGallery() {
    for (let i = 0; i < 12; i++) {
        var smallImg = document.createElement("img");
        smallImg.setAttribute("src", compresedSources[i]);
        smallImg.setAttribute("id", i + "-photo");
        smallImg.setAttribute("class", "icons");
        smallImg.addEventListener("click",
            function() {
                gallery.src = compresedSources[i];
                choice = i;
            });
        var viewer = document.getElementById("icons");
        viewer.appendChild(smallImg);
    }
}

function fullGallery() {
    var promises = [];
    for (i = 0; i < 12; i++) {
        var promise = getImage(sources[i], i);
        promises.push(promise);
    }
    Promise.all(promises).then(function() {
        console.log("Every image loaded!");
    }).catch(function() {
        console.log("Error while loading!");
    })
}

function getImage(source, number) {
    return new Promise(function(resolve, reject) {
        var fullImage = document.getElementById(number + "-photo");
        fullImage.setAttribute("src", source);
        fullImage.onload = function() { resolve(source, number) };
        fullImage.onerror = function() { reject(source) };
    });

}

function click() {
    columns = colsInput.value;
    rows = rowsInput.value;
    setCanvas();
    shuffling = (columns * rows) * 100;
    img.src = gallery.src;
}

function resetClick() {
    colsVal.innerHTML = DEFAULT_COLS;
    rowsVal.innerHTML = DEFAULT_ROWS;
    colsInput.value = DEFAULT_COLS;
    rowsInput.value = DEFAULT_ROWS;
    gallery.src = sources[0];
    choice = 0;
}

function prev() {
    choice--;
    if (choice < 0) {
        choice = 11;
    }
    setup();
}

function nxt() {
    choice++;
    if (choice > 11) {
        choice = 0;
    }
    setup();
}

function setup() {
    gallery.src = sources[choice];
}

function changeCols() {
    colsVal.innerHTML = colsInput.value;
}

function changeRows() {
    rowsVal.innerHTML = rowsInput.value;
}

function setCanvas() {
    canvas.height = 0.8 * window.innerHeight;
    if (window.innerWidth < 1000) {
        canvas.width = gallery.width;
    } else {
        canvas.width = 1.7 * gallery.width;
    }
    canvas.style.border = "5px solid black";
}

function setImage() {
    pieceHeight = canvas.height / rows;
    pieceWidth = canvas.width / columns;
    elementHeight = img.height / rows;
    elementWidth = img.width / columns;
    initPuzzle();
}

function initPuzzle() {
    pieces = [];
    mouse = { x: 0, y: 0 };
    touch = { x: 0, y: 0 };
    var piece;
    var xImg = 0;
    var yImg = 0;
    var xCan = 0;
    var yCan = 0;
    for (i = 0; i < rows * columns; i++) {
        piece = {};
        piece.x = xImg;
        piece.y = yImg;
        piece.xPos = xCan;
        piece.yPos = yCan;
        piece.xRow = i % columns;
        piece.yRow = Math.floor(i / columns);
        pieces.push(piece);
        xImg += elementWidth;
        xCan += pieceWidth;
        if (piece.xRow == columns - 1) {
            xImg = 0;
            yImg += elementHeight;
            xCan = 0;
            yCan += pieceHeight;
        }
    }
    shuffle();
}

function shuffle() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    redPiece = pieces[Math.floor(Math.random() * columns * rows)];
    shuffleArray(pieces);
    draw();
    document.onmousedown = move;
    document.onmousemove = light;
}

function shuffleArray(pieces) {
    redPiece = pieces[Math.floor(Math.random() * columns * rows)];
    var piece;
    var swap;
    var neighbours;
    var counter = 0;
    while (!(redPiece.xRow == 0 && redPiece.yRow == 0) || counter < shuffling) {
        neighbours = [];
        for (j = 0; j < columns * rows; j++) {
            piece = pieces[j];
            if (redNeighbour(piece)) {
                neighbours.push(piece);
            }
        }
        swap = Math.floor(Math.random() * neighbours.length);
        swapPieces(neighbours[swap]);
        counter++;
    }
}

function draw() {
    var piece;
    for (i = 0; i < pieces.length; i++) {
        piece = pieces[i];
        if (piece == redPiece) {
            ctx.fillStyle = "#FF0000";
            ctx.fillRect(redPiece.xPos, redPiece.yPos, pieceWidth, pieceHeight);
        } else {
            ctx.drawImage(img, piece.x, piece.y, elementWidth, elementHeight, piece.xPos, piece.yPos, pieceWidth, pieceHeight);
            ctx.strokeRect(piece.xPos, piece.yPos, pieceWidth, pieceHeight);
        }
    }
}

function move(e) {
    var rect = canvas.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
    currentPiece = pieceClicked(mouse);
    if (currentPiece != null) {
        if (redNeighbour(currentPiece)) {
            swapPieces(currentPiece);
            if (currentLightedPiece != null) {
                ctx.globalAlpha = 1;
                ctx.drawImage(img, currentLightedPiece.x, currentLightedPiece.y, pieceWidth, pieceHeight, currentLightedPiece.xPos, currentLightedPiece.yPos, pieceWidth, pieceHeight);
                ctx.strokeRect(currentLightedPiece.xPos, currentLightedPiece.yPos, pieceWidth, pieceHeight);
                currentLightedPiece = null;
            }
            redraw();
            gameOver();
        }
    }
}

function pieceClicked(field) {
    if (currentLightedPiece == field) {
        return null;
    }

    var piece;
    for (i = 0; i < pieces.length; i++) {
        piece = pieces[i];
        if (field.x > piece.xPos && field.x < (piece.xPos + pieceWidth) && field.y > piece.yPos && field.y < (piece.yPos + pieceHeight)) {
            return piece;
        }
    }
    return null;
}

function redNeighbour(piece) {
    if ((Math.abs(piece.xRow - redPiece.xRow) == 1 && piece.yRow == redPiece.yRow) || (Math.abs(piece.yRow - redPiece.yRow) == 1 && piece.xRow == redPiece.xRow)) {

        return true;
    } else {
        return false;
    }
}

function swapPieces(piece) {
    var tmpX = piece.xPos;
    var tmpY = piece.yPos;
    var tmpXr = piece.xRow;
    var tmpYr = piece.yRow;
    piece.xPos = redPiece.xPos;
    piece.yPos = redPiece.yPos;
    piece.xRow = redPiece.xRow;
    piece.yRow = redPiece.yRow;
    redPiece.xPos = tmpX;
    redPiece.yPos = tmpY;
    redPiece.xRow = tmpXr;
    redPiece.yRow = tmpYr;
}

function redraw() {
    ctx.drawImage(img, currentPiece.x, currentPiece.y, elementWidth, elementHeight, currentPiece.xPos, currentPiece.yPos, pieceWidth, pieceHeight);
    ctx.strokeRect(currentPiece.xPos, currentPiece.yPos, pieceWidth, pieceHeight);
    ctx.fillStyle = "#FF0000";
    ctx.fillRect(redPiece.xPos, redPiece.yPos, pieceWidth, pieceHeight);
}

function light(e) {
    var rect = canvas.getBoundingClientRect();
    touch.x = e.clientX - rect.left;
    touch.y = e.clientY - rect.top;
    if (currentLightedPiece != null && currentLightedPiece != redPiece) {
        ctx.globalAlpha = 1;
        ctx.drawImage(img, currentLightedPiece.x, currentLightedPiece.y, elementWidth, elementHeight, currentLightedPiece.xPos, currentLightedPiece.yPos, pieceWidth, pieceHeight);
        ctx.strokeRect(currentLightedPiece.xPos, currentLightedPiece.yPos, pieceWidth, pieceHeight);
    }
    currentLightedPiece = pieceClicked(touch);
    if (currentLightedPiece != null) {
        if (redNeighbour(currentLightedPiece)) {
            ctx.fillStyle = "#0000FF";
            ctx.globalAlpha = 0.3;
            ctx.fillRect(currentLightedPiece.xPos, currentLightedPiece.yPos, pieceWidth, pieceHeight);
            ctx.strokeRect(currentLigthedPiece.xPos, currentLightedPiece.yPos, pieceWidth, pieceHeight);
        }
    }
}

function gameOver() {
    var piece;
    for (i = 0; i < pieces.length; i++) {
        piece = pieces[i];
        if (piece == redPiece) {
            continue;
        }
        if (piece.x != piece.xRow * elementWidth || piece.y != piece.yRow * elementHeight) {
            return false;
        }
    }
    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    alert("You win!");
    document.onmousedown = null;
    document.onmousemove = null;
}