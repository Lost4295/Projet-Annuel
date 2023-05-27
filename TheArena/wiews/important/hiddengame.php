<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php" ?>

<canvas id="game-canvas" width="300" height="600"></canvas>
<h2 id="scoreboard">Score: 0</h2>
<h2 id="lines-cleared">Lignes réalisées: 0</h2>
<p>Vous avez trouvé le jeu caché ! Utilisez les touches fléchées ou ZQSD pour déplacer les blocs. (↑ ou Z pour les faie tourner)</p>
<script>
    var GAME_CLOCK = 1000
    const BLOCK_SIDE_LENGTH = 30
    const ROWS = 20
    const COLS = 10
    var SCORE_WORTH = 10
    var modify = 5
    var clkmodify = 15
    let restartButton = null;
    let linesCleared = 0;

    const SHAPES = [
        [],
        [
            [0, 0, 0, 0],
            [1, 1, 1, 1],
            [0, 0, 0, 0],
            [0, 0, 0, 0]
        ],

        [
            [2, 0, 0],
            [2, 2, 2],
            [0, 0, 0],
        ],

        [
            [0, 0, 3],
            [3, 3, 3],
            [0, 0, 0],
        ],

        [
            [4, 4],
            [4, 4],
        ],

        [
            [0, 5, 5],
            [5, 5, 0],
            [0, 0, 0],
        ],

        [
            [0, 6, 0],
            [6, 6, 6],
            [0, 0, 0],
        ],

        [
            [7, 7, 0],
            [0, 7, 7],
            [0, 0, 0],
        ],

    ]

    const COLORS = [
        '#000000',
        '#FF0000',
        '#00FF00',
        '#0000FF',
        '#FFFF00',
        '#00FFFF',
        '#10FF01',
        '#F000FF'
    ]
    let gameOver = false;

    class Piece {
        constructor(shape, ctx) {
            this.shape = shape
            this.ctx = ctx
            this.y = 0
            this.x = Math.floor(COLS / 2)
        }

        renderPiece() {
            this.shape.map((row, i) => {
                row.map((cell, j) => {
                    if (cell > 0) {
                        this.ctx.fillStyle = COLORS[cell]
                        this.ctx.fillRect(this.x + j, this.y + i, 1, 1)
                    }
                })
            })
        }
    }
    class GameModel {
        constructor(ctx) {
            this.ctx = ctx
            this.fallingPiece = null // piece
            this.grid = this.makeStartingGrid()
        }

        makeStartingGrid() {
            let grid = []
            for (var i = 0; i < ROWS; i++) {
                grid.push([])
                for (var j = 0; j < COLS; j++) {
                    grid[grid.length - 1].push(0)
                }
            }
            return grid
        }

        collision(x, y, candidate = null) {
            const shape = candidate || this.fallingPiece.shape
            const n = shape.length
            for (let i = 0; i < n; i++) {
                for (let j = 0; j < n; j++) {
                    if (shape[i][j] > 0) {
                        let p = x + j
                        let q = y + i
                        if (p >= 0 && p < COLS && q < ROWS) {
                            // in bounds
                            if (this.grid[q][p] > 0) {
                                return true
                            }
                        } else {
                            return true
                        }
                    }
                }
            }
            return false
        }


        renderGameState() {
            if (gameOver && restartButton === null) {
                // Créer un bouton pour relancer la partie
                restartButton = document.createElement("button");
                restartButton.textContent = "Relancer";
                restartButton.classList = "btn btn-primary";
                restartButton.addEventListener("click", () => {
                    restartGame(); // Appelle la fonction restartGame au lieu de location.reload()
                });

                // Trouver l'élément <h2>
                const heading = document.getElementById("lines-cleared");

                // Ajouter le bouton au document
                heading.parentNode.insertBefore(restartButton, heading.nextSibling);


            } else if (!gameOver && restartButton !== null && restartButton.parentNode) {
                // Retirer le bouton du document si le jeu est en cours
                restartButton.parentNode.removeChild(restartButton);
            }


            for (let i = 0; i < this.grid.length; i++) {
                for (let j = 0; j < this.grid[i].length; j++) {
                    let cell = this.grid[i][j]
                    this.ctx.fillStyle = COLORS[cell]
                    this.ctx.fillRect(j, i, 1, 1)
                }
            }

            if (this.fallingPiece !== null) {
                this.fallingPiece.renderPiece()
            }
        }


        moveDown() {
            if (this.fallingPiece === null) {
                this.renderGameState()
                return
            } else if (this.collision(this.fallingPiece.x, this.fallingPiece.y + 1)) {
                const shape = this.fallingPiece.shape
                const x = this.fallingPiece.x
                const y = this.fallingPiece.y
                shape.map((row, i) => {
                    row.map((cell, j) => {
                        let p = x + j
                        let q = y + i
                        if (p >= 0 && p < COLS && q < ROWS && cell > 0) {
                            this.grid[q][p] = shape[i][j]
                        }
                    })
                })

                // check game over 
                if (this.fallingPiece.y === 0) {
                    alert("La partie est terminée !");
                    gameOver = true;
                    this.grid = this.makeStartingGrid();
                }
                this.fallingPiece = null
            } else {
                this.fallingPiece.y += 1
            }
            this.renderGameState()
        }

        move(right) {
            if (this.fallingPiece === null) {
                return
            }

            let x = this.fallingPiece.x
            let y = this.fallingPiece.y
            if (right) {
                // move right
                if (!this.collision(x + 1, y)) {
                    this.fallingPiece.x += 1
                }
            } else {
                // move left
                if (!this.collision(x - 1, y)) {
                    this.fallingPiece.x -= 1
                }
            }
            this.renderGameState()
        }

        rotate() {
            if (this.fallingPiece !== null) {
                let shape = [...this.fallingPiece.shape.map((row) => [...row])]
                // transpose of matrix 
                for (let y = 0; y < shape.length; ++y) {
                    for (let x = 0; x < y; ++x) {
                        [shape[x][y], shape[y][x]] = [shape[y][x], shape[x][y]]
                    }
                }
                // reverse order of rows 
                shape.forEach((row => row.reverse()))
                if (!this.collision(this.fallingPiece.x, this.fallingPiece.y, shape)) {
                    this.fallingPiece.shape = shape
                }
            }
            this.renderGameState()
        }
    }
    // setup 

    let canvas = document.getElementById("game-canvas")
    let scoreboard = document.getElementById("scoreboard");
    let lines = document.getElementById("lines-cleared");
    let ctx = canvas.getContext("2d")
    ctx.scale(BLOCK_SIDE_LENGTH, BLOCK_SIDE_LENGTH)
    let model = new GameModel(ctx)

    let score = 0


    let currentInterval = null;


    let newGameState = () => {
        fullSend();

        if (!gameOver) {
            if (model.fallingPiece === null) {
                const rand = Math.round(Math.random() * 6) + 1;
                const newPiece = new Piece(SHAPES[rand], ctx);
                model.fallingPiece = newPiece;
                model.moveDown();
            } else {
                model.moveDown();
            }
        }
    }

    const fullSend = () => {
        const allFilled = (row) => {
            for (let x of row) {
                if (x === 0) {
                    return false
                }
            }
            return true
        }
        // Variable pour compter le nombre de lignes complètes

        for (let i = 0; i < model.grid.length; i++) {
            if (allFilled(model.grid[i])) {
                score += SCORE_WORTH;
                model.grid.splice(i, 1);
                model.grid.unshift(new Array(COLS).fill(0));
                SCORE_WORTH += modify;
                linesCleared++; // Incrémente le compteur de lignes complètes
                if (linesCleared > 0) {
                    GAME_CLOCK -= linesCleared * clkmodify;
                    if (GAME_CLOCK < 0) {
                        GAME_CLOCK = 0;
                    }
                    updateInterval();
                }
            }
        }

        // Accélère la descente des blocs en fonction du nombre de lignes complètes


        scoreboard.innerHTML = "Score: " + String(score);
        lines.innerHTML = "Lignes réalisées : " + String(linesCleared);
    }

    const updateInterval = () => {
        if (currentInterval !== null) {
            clearInterval(currentInterval);
        }
        currentInterval = setInterval(() => {
            newGameState()
        }, GAME_CLOCK);
    }

    // Appelle updateInterval au démarrage du jeu
    updateInterval();


    const restartGame = () => {
        score = 0;
        model.grid = model.makeStartingGrid();
        gameOver = false;
        restartButton.parentNode.removeChild(restartButton);
        linesCleared = 0;
        updateInterval(); // Réinitialise l'intervalle du jeu
        newGameState(); // Démarre une nouvelle partie
    };


    document.addEventListener("keydown", (e) => {
        e.preventDefault()
        switch (e.key) {
            case "z":
            case "ArrowUp":
                model.rotate()
                break
            case "d":
            case "ArrowRight":
                model.move(true)
                break
            case "s":
            case "ArrowDown":
                model.moveDown()
                break
            case "q":
            case "ArrowLeft":
                model.move(false)
                break
        }
    })
</script>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>