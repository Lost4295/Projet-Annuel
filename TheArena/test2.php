<!-- TODO faire en sorte de finir les events en entier (crud sur shop, back + front avec tout ce qu'il faut) -->



<?php 
require $_SERVER['DOCUMENT_ROOT'].'/core/header.php'; ?>
//TODO continue this
<style>
    :root {
    --vh: 1vh;
    --BORDER_GAP: 6px;
    --BORDER_RADIUS: 3px;
    --COLOR_TEXT_CANVAS_TRANSPARENT: #404040;
    --COLOR_PANEL_BG: rgba(12, 44, 150, 0.75);
    --COLOR_PANEL_LO: rgba(7, 36, 131, 0.75);
    --COLOR_PANEL_HI: #1640c9;
    --COLOR_PANEL_FOCUS: #ee9631;
    --COLOR_PANEL_BORDER: #040a33;
    --COLOR_PANEL_BORDER_FOCUS: #56b2fd;
    --COLOR_PANEL_TEXT: #f0f0f0;
    --COLOR_PANEL_TEXT_FOCUS: white;
    --COLOR_PANEL_TEXT_PLACEHOLDER: #9b9b9b;
    --COLOR_PANEL_BUTTON: #2a51d1;
    --COLOR_PANEL_BUTTON_HOVER: #1e44be;
    --COLOR_PANEL_BUTTON_ACTIVE: #1d40b4;
}
.avatar {
    pointer-events: none;
    user-select: none;
    position: relative;
    flex: 0 0 auto;
    height: 100%;
    width: 100%;
    image-rendering: -moz-crisp-edges;
    image-rendering: crisp-edges;
    -ms-interpolation-mode: nearest-neighbor;
    image-rendering: pixelated;
}

.avatar.fit {
    width: 100%;
    height: 100%;
}

.avatar.clicked {
    animation: avatar_clicked 125ms ease-in-out 1
}

.avatar .eyes.bounce,.avatar .mouth.bounce {
    animation: avatar_bounce 125ms ease-in-out 1;
}

.avatar .color {
    position: absolute;
    width: 100%;
    height: 100%;
    background-image: url('https://skribbl.io/img/avatar/color_atlas.gif');
    background-size: 1000% 1000%
}

.avatar .eyes {
    position: absolute;
    width: 100%;
    height: 100%;
    background-image: url('https://skribbl.io/img/avatar/eyes_atlas.gif');
    background-size: 1000% 1000%
}

.avatar .mouth {
    position: absolute;
    width: 100%;
    height: 100%;
    background-image: url('https://skribbl.io/img/avatar/mouth_atlas.gif');
    background-size: 1000% 1000%
}

.avatar .special {
    position: absolute;
    left: -33%;
    top: -33%;
    width: 166%;
    height: 166%;
    background-image: url('https://skribbl.io/img/avatar/special_atlas.gif');
    background-size: 1000% 1000%
}

.avatar .owner {
    position: absolute;
    width: 50%;
    height: 50%;
    left: -5%;
    top: -22%;
    z-index: 2;
    background-image: url('https://skribbl.io/img/crown.gif');
    background-position: center;
    background-size: contain
}
.panels {
    display: flex;
    width: 100%
}

.panel {
    flex: 0 0 auto;
    width: 400px;
    background-color: var(--COLOR_PANEL_BG);
    border-radius: var(--BORDER_RADIUS);
    padding: 15px
}

.panel-left {
    margin-right: 8px;
    flex: 1 1 50%;
    display: flex;
    align-items: flex-end;
    justify-content: flex-end
}

.panel-right {
    margin-left: 8px;
    flex: 1 1 50%;
    display: flex;
    flex-direction: column;
    justify-content: space-between
}

.avatar-customizer {
    margin-top: 10px;
    margin-bottom: 10px;
    display: flex;
    justify-content: center;
    position: relative;
    background: rgba(0,0,0,.1);
    padding: 8px;
    border-radius: var(--BORDER_RADIUS)
}

.avatar-customizer .randomize {
    cursor: pointer;
    position: absolute;
    width: 32px;
    height: 32px;
    right: 4px;
    top: 4px;
    opacity: .6;
    background-image: url('https://skribbl.io/img/randomize.gif');
    transition: opacity .15s ease,transform .15s ease
}

.avatar-customizer .randomize:hover {
    opacity: 1;
    transform: scale(1.2)
}

.avatar-customizer .container {
    width: 105px;
    height: 105px;
}

.avatar-customizer .arrows {
    display: flex;
    flex-direction: column;
    justify-content: space-around
}

.avatar-customizer .arrows .arrow {
    filter: drop-shadow(0 0 3px rgba(0, 0, 0, .15));
    flex: 0 0 auto;
    cursor: pointer;
    width: 34px;
    height: 34px;
    background-image: url('https://skribbl.io/img/arrow.gif');
    background-size: 200%;
    background-repeat: no-repeat
}

.avatar-customizer .arrows.left .arrow {
    background-position: 0 0
}

.avatar-customizer .arrows.left .arrow:hover {
    background-position: 100% 0
}

.avatar-customizer .arrows.right .arrow {
    background-position: 0 100%
}

.avatar-customizer .arrows.right .arrow:hover {
    background-position: 100% 100%
}
@keyframes avatar_bounce {
    0%,100% {
        top: 0
    }

    15% {
        top: 6%
    }
}

@keyframes avatar_clicked {
    0%,100% {
        transform: scale(1)
    }

    15% {
        transform: scale(1.2)
    }
}

</style>


<div class="panels">
    <div class="panel-left"></div>
    <div class="panel">
        <div class="avatar-customizer">
            <div class="arrows left">
                <div class="arrow left" onclick="changeAttr(id)" id="0" data-avatar-index="1"></div>
                <div class="arrow left" onclick="changeAttr(id)" id="1" data-avatar-index="2"></div>
                <div class="arrow left" onclick="changeAttr(id)" id="2" data-avatar-index="0"></div>
            </div>
            <div class="container">
                <div class="avatar fit">
                    <div class="color" style="background-position: 0% 0%;"></div>
                    <div class="eyes" style="background-position: 0% 0%;"></div>
                    <div class="mouth" style="background-position: 0% 0%;"></div>
                    <div class="special" style="display: none;"></div>
                    <div class="owner" style="display: none;"></div>
                </div>
            </div>
            <div class="arrows right">
                <div class="arrow right" onclick="changeAttr(id)" id="3" data-avatar-index="1"></div>
                <div class="arrow right" onclick="changeAttr(id)" id="4" data-avatar-index="2"></div>
                <div class="arrow right" onclick="changeAttr(id)" id="5" data-avatar-index="0"></div>
            </div>
            <div class="randomize" data-tooltip="Randomize your Avatar!" data-tooltipdir="N"></div>
        </div>
    </div>
    <div class="panel-right">
    </div>
</div>

<script>

var larrows = document.querySelectorAll('.arrows .left');
var rarrows = document.querySelectorAll('.arrows .right');

function changeAttr(id){
    console.log(id)
    var elem= document.getElementById(id)
    console.log(elem.dataset.avatarIndex)
    var index =elem.dataset.avatarIndex
    var color = document.getElementsByClassName("color")[0]
    var eyes = document.getElementsByClassName("eyes")[0]
    var mouth = document.getElementsByClassName("mouth")[0]
    var special = document.getElementsByClassName("special")[0]
    var owner = document.getElementsByClassName("owner")[0]
    switch (index){
        case 0:
            if (eyes.classList.contains("avatar-clicked")){
                eyes.classList.remove("avatar-clicked")
            }
            if (mouth.classList.contains("avatar-clicked")){
                mouth.classList.remove("avatar-clicked")
            }
            if (special.classList.contains("avatar-clicked")){
                special.classList.remove("avatar-clicked")
            }
            if (owner.classList.contains("avatar-clicked")){
                owner.classList.remove("avatar-clicked")
            }
            color.classList.add("avatar-clicked")
            color.style.backgroundPositionX.replace('%','')
            color.style.backgroundPositionX += 100 +"%"
        case 1:
            if (color.classList.contains("avatar-clicked")){
                color.classList.remove("avatar-clicked")
            }
            if (mouth.classList.contains("avatar-clicked")){
                mouth.classList.remove("avatar-clicked")
            }
            if (special.classList.contains("avatar-clicked")){
                special.classList.remove("avatar-clicked")
            }
            if (owner.classList.contains("avatar-clicked")){
                owner.classList.remove("avatar-clicked")
            }
            eyes.classList.add("avatar-clicked")
            eyes.style.backgroundPositionX.replace('%','')
            eyes.style.backgroundPositionX += 100 +"%"
        case 2:

        default:
        console.log(color.style.backgroundPositionX)
        console.log(color.style.backgroundPositionY)
        console.log(eyes.style.backgroundPosition)
        console.log(mouth.style.backgroundPosition)
        }
}

</script>

<?php 



require $_SERVER['DOCUMENT_ROOT'].'/core/footer.php'; ?>




