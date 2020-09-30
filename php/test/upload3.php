<body style="margin:0">
  <canvas id="canvasElem" width="100" height="80" style="border:1px solid"></canvas>

  <input type="button" value="Submit" onclick="submit()">
  <input type="file" name="img">

  <script>
    canvasElem.onmousemove = function(e) {
      let ctx = canvasElem.getContext('2d');
      ctx.lineTo(e.clientX, e.clientY);
      ctx.stroke();
    };

    async function submit() {
      let imageBlob = await new Promise(resolve => canvasElem.toBlob(resolve, 'image/png'));

      let formData = new FormData();
      formData.append("firstName", "John");
      formData.append("image", imageBlob, "image.png");
      //formData.append("image", "c:\temp\logo.png", "logo.png");

      let response = await fetch('upload4.php', {
        method: 'POST',
        body: formData
      });
      let result = await response.json();
      //alert(result.message);
    }

  </script>
</body>