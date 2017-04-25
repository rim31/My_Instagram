


<nav>

<input id="submit" TYPE="submit" name="upload" title="Add data to the Database" value="Add photo" hidden/>

<div class="flexFiltre">
<div class="miniFiltre"><IMG id="mini" value="1" SRC="image/bbm_mini.png" onclick="chooseFilter(this, 1)" style="width:50px;"></div>
<div class="miniFiltre"><IMG id="mini" value="2" SRC="image/donuts.png" onclick="chooseFilter(this, 2)" style="width:50px;"></div>
<div class="miniFiltre"><IMG id="mini" value="3" SRC="image/Untitled.png" onclick="chooseFilter(this, 3)" style="width:50px;"></div>
<div class="miniFiltre"><IMG id="mini" value="4" SRC="image/bbm.png" onclick="chooseFilter(this, 4)" style="width:50px;"></div>
<div class="miniFiltre"><IMG id="mini" value="5" SRC="image/neige_mini.png" onclick="chooseFilter(this, 5)" style="width:50px;"></div>
<div class="miniFiltre"><IMG id="mini" value="6" SRC="image/effeil.png" onclick="chooseFilter(this, 6)" style="width:50px;"></div>
<!-- <div class="miniFiltre"><IMG id="mini" value="7" SRC="image/pokemon.gif" onclick="chooseFilter(this, 7)" style="width:50px;"></div> -->
</div>
</nav>

<button id="snap">Snap Photo</button><BR/>

<article>
<img id="filtre" src="" alt="" style="position:absolute" width="640" height="480"/>
  <video id="video" width="640" height="480" autoplay></video><BR/>
</article>
<button id="snap">Preview</button><BR/>
<article>
  <canvas style="position:absolute;" id="canvas" width="640" height="480"></canvas>
  <img id="filtre1" src="" alt="" style="position:relative;" width="640" height="480"/>
</article>

<script>
     var video = document.querySelector("#videoElement");

    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;


if (navigator.getUserMedia) {
	navigator.getUserMedia({video: true}, handleVideo, videoError);
	}
else if(navigator.getUserMedia) { // Standard
	navigator.getUserMedia({ video: true }, function(stream) {
	video.src = stream;
	video.play();
	}, errBack);
} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
	navigator.webkitGetUserMedia({ video: true }, function(stream){
	video.src = window.webkitURL.createObjectURL(stream);
	video.play();
	}, errBack);
} else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
	navigator.mozGetUserMedia({ video: true }, function(stream){
	video.src = window.URL.createObjectURL(stream);
	video.play();
	}, errBack);
}

      // Elements for taking the snapshot
      var canvas = document.getElementById('canvas');
      var context = canvas.getContext('2d');
      var video = document.getElementById('video');

  document.getElementById("snap").addEventListener("mouseover", function() {
          context.drawImage(video, 0, 0, 640, 480);
	var x = document.getElementById("filtre").alt;
	var y = document.getElementById("filtre1");
	if (x == 1) {
		y.setAttribute("src", "image/stachmou.png");
	}
	else if (x == 2) {
		y.setAttribute("src", "image/donuts.png");
	}
	else if (x == 3) {
		y.setAttribute("src", "image/carey.png");
	}
	else if (x == 4) {
		y.setAttribute("src", "image/bbm.png");
	}
	else if (x == 5) {
		y.setAttribute("src", "image/neige_mini.png");
	}
	else if (x == 6) {
		y.setAttribute("src", "image/effeil.png");
	}
   });

      document.getElementById("snap").addEventListener("mouseout", function() {
          context.clearRect(0, 0, canvas.width, canvas.height);
	var y = document.getElementById("filtre1");
	y.setAttribute("src", "");
   });

      document.getElementById("submit").addEventListener("click", function() {
          context.drawImage(video, 0, 0, 640, 480);
   });

      // Conversion de la cam en photo
      document.getElementById("snap").addEventListener("click", function() {
          context.drawImage(video, 0, 0, 640, 480);
          var img = convertCanvasToImage(canvas);

	var y = document.getElementById("filtre1").alt;
          var params = [];
    img = canvas.toDataURL("image/png");
    // console.log(img);
    params["numerofiltre"] = document.getElementById("filtre").alt;


    params["img"] = img;
    method = "post";
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", "src/saveCamera.php");
    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.appendChild(hiddenField);
        }
    }
    document.body.appendChild(form);
    if (params["numerofiltre"]) {
    	form.submit();
    }
    });

function chooseFilter(me, id) {
	var x = document.getElementById("filtre");
	x.setAttribute("alt", id);

		if (id == 1) {
			x.setAttribute("src", "image/stachmou.png");
		}
		else if (id == 2) {
			x.setAttribute("src", "image/donuts.png");
		}
		else if (id == 3) {
			x.setAttribute("src", "image/carey.png");
		}
		else if (id == 4) {
			x.setAttribute("src", "image/bbm.png");
		}
		else if (id == 5) {
			x.setAttribute("src", "image/neige_mini.png");
		}
		else if (id == 6) {
			x.setAttribute("src", "image/effeil.png");
		}
}

    function handleVideo(stream) {
        video.src = window.URL.createObjectURL(stream);
    }

    function videoError(e) {
        // do something
    }

function convertCanvasToImage(canvas) {
	var image = new Image();
	image.src = canvas.toDataURL("image/png");
	return image;
}




</script>
