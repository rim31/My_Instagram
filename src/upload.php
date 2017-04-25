
<?php
// var_dump ($_SESSION['auth']->id);
?>
<div class="mainDiv">
  <form action="src/saveUpload.php" method="post"
  enctype="multipart/form-data">
  <div class="fileInput instructionsDiv">
    <h3>Optimisé pour des images 640 x 480</h3>
    <h3>image < 2 Mo</h3>
    <input type="file" name="file" id="file" class="inputfile" onchange="readURL(this);" >
    <span class="fileSpan">
      <input type="text" name="numerofiltre" id="lopetteValeurFiltre" value="" hidden>
    </span>
  </div>
  <input id="submit" TYPE="submit" name="upload" title="Add data to the Database" value="Add photo" hidden/>
  <div class="flexFiltre">
    <div class="miniFiltre">
      <IMG id="mini" value="1" SRC="image/bbm_mini.png" onclick="chooseFilter(this, 1)" style="width:50px;">
      </div>
      <div class="miniFiltre">
        <IMG id="mini" value="2" SRC="image/donuts.png" onclick="chooseFilter(this, 2)" style="width:50px;">
        </div>
        <div class="miniFiltre">
          <IMG id="mini" value="3" SRC="image/Untitled.png" onclick="chooseFilter(this, 3)" style="width:50px;">
          </div>
          <div class="miniFiltre">
            <IMG id="mini" value="4" SRC="image/bbm.png" onclick="chooseFilter(this, 4)" style="width:50px;">
            </div>
            <div class="miniFiltre">
              <IMG id="mini" value="5" SRC="image/neige_mini.png" onclick="chooseFilter(this, 5)" style="width:50px;">
              </div>
              <div class="miniFiltre">
                <IMG id="mini" value="6" SRC="image/effeil.png" onclick="chooseFilter(this, 6)" style="width:50px;">
                </div>
            <!--  <div class="miniFiltre">
                  <IMG id="mini" value="7" SRC="image/pokemon.gif" onclick="chooseFilter(this, 7)" style="width:50px;">
                  </div> -->
                </div>


                <!-- <input type="submit" value="envoyer" class="snap"> -->

                <button id="snap" style="display:none;">Snap Photo</button>
                <!-- </form> -->

                <article>
                  <canvas style="position:absolute;" id="canvas" width="640" height="480"></canvas>
                  <img id="filtre1" src="" alt="" style="position:absolute; width:640; height:480; z-index:1;"/>
                  <img id="previewUpload" src="" alt="your image" style="position:absolute; max-width:640; max-height:480; z-index:-1;"/>
                  <img id="filtre" src="" alt="" style="position:absolute" width="640" height="480"/>
                  <video id="video" width="640" height="480" autoplay></video>
                  <!-- <button id="snap">Snap Photo</button> -->

                </article>

              </div>

              <script>

              // document.addEventListener("DOMContentLoaded", function(e) {
              document.addEventListener("click", function(e) {
                var url = document.location.href;
                var previewImg = document.getElementById("previewUpload").src;
                var presenceFiltre = document.getElementById("filtre").src;
                var testPreviewImg = url.localeCompare(previewImg);
                var testPresenceFiltre = url.localeCompare(presenceFiltre);
                // console.log(testPreviewImg);
                // console.log(testPresenceFiltre);
                if (testPreviewImg != 0 && testPresenceFiltre != 0 ) {
                  document.getElementById("snap").style.display="block";
                }
                else {
                  document.getElementById("snap").style.display="none";
                }
              });

              // Elements for taking the snapshot
              var canvas = document.getElementById('canvas');
              var context = canvas.getContext('2d');
              var video = document.getElementById('video');

              document.getElementById("snap").addEventListener("mouseover", function() {
                context.drawImage(video, 0, 0, 640, 480);
                var x = document.getElementById("filtre").alt;
                var y = document.getElementById("filtre1");
                var z = document.getElementById("lopetteValeurFiltre");
                if (x == 1) {
                  y.setAttribute("src", "image/stachmou.png");
                  z.setAttribute("value", "1");
                }
                else if (x == 2) {
                  y.setAttribute("src", "image/donuts.png");
                  z.setAttribute("value", "2");
                }
                else if (x == 3) {
                  y.setAttribute("src", "image/carey.png");
                  z.setAttribute("value", "3");
                }
                else if (x == 4) {
                  y.setAttribute("src", "image/bbm.png");
                  z.setAttribute("value", "4");
                }
                else if (x == 5) {
                  y.setAttribute("src", "image/neige_mini.png");
                  z.setAttribute("value", "5");
                }
                else if (x == 6) {
                  y.setAttribute("src", "image/effeil.png");
                  z.setAttribute("value", "6");
                }
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
                form.setAttribute("action", "src/snapphoto.php");
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



              // http://codepen.io/waqasy/pen/rkuJf

              function readURL(input) {
                if (input.files && input.files[0]) {
                  var reader = new FileReader();

                  reader.onload = function (e) {
                    $('#previewUpload')
                    .attr('src', e.target.result);
                  };

                  reader.readAsDataURL(input.files[0]);
                }
              }



              </script>
