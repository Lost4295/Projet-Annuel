<body onload="generate()">





    <div class="panel">
        <div class="container" style="max-width: 450px;max-height: 450px;">
        <style>
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

        .avatar .eyes.bounce,
        .avatar .mouth.bounce {
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
            border-radius: 3px;
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
            background: rgba(0, 0, 0, .1);
            padding: 8px;
            border-radius: 3px;
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
            transition: opacity .15s ease, transform .15s ease
        }

        .avatar-customizer .randomize:hover {
            opacity: 1;
            transform: scale(1.2)
        }

        .avatar-customizer .container {
            width: 160px;
            margin: unset;
            height: 130px;
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

            0%,
            100% {
                top: 0
            }

            15% {
                top: 6%
            }
        }

        @keyframes avatar_clicked {

            0%,
            100% {
                transform: scale(1)
            }

            15% {
                transform: scale(1.2)
            }
        }
    </style>
            <div class="avatar fit">
                <div class="color" style="background-position: 0% 0%;"></div>
                <div class="eyes" style="background-position: 0% 0%;"></div>
                <div class="mouth" style="background-position: 0% 0%;"></div>
                <div class="special" style="display: none;"></div>
                <div class="owner" style="display: none;"></div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function takeScreenshot() {
            const placeholder = document.createElement("div");
            placeholder.innerHTML = document.getElementsByClassName('panel')[0].innerHTML;
             let test= document.getElementsByClassName('panel')[0];
            const noded = placeholder.firstElementChild;
            var screenshot = noded
                .cloneNode(true);
            screenshot.style.pointerEvents = 'none';
            screenshot.style.overflow = 'hidden';
            screenshot.style.webkitUserSelect = 'none';
            screenshot.style.mozUserSelect = 'none';
            screenshot.style.msUserSelect = 'none';
            screenshot.style.oUserSelect = 'none';
            screenshot.style.userSelect = 'none';
            screenshot.dataset.scrollX = 500;
            screenshot.style.maxWidth = '500px';
            screenshot.style.maxHeight = '500px';
            screenshot.dataset.scrollY = 500;
            var blob = new Blob([screenshot.outerHTML], {
                type: 'text/html'
            });
            console.log(blob);
            return blob;

        }

        function generate() {
            window.URL = window.URL || window.webkitURL;
            window.open(window.URL
                .createObjectURL(takeScreenshot()));
        }
    </script>