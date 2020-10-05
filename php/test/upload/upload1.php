
<body>
<form id="form1" method="post">
  <input type="button" value="Enviar" onclick="enviar()">
  <input type="file" name="file" multiple>
  <input type="text" id="name" name="name" value="bla11">
  <input type="text" id="fname" name="fname" value="bla22">
</form>
<script>

    async function enviar() {

      try {

          const data = new URLSearchParams();
          let form = document.getElementById('form1');
          let formData = new FormData(form);
          for (const pair of formData) {
              data.append(pair[0], pair[1]);
          }

          var input = document.querySelector('input[type="file"]')         
          for (let file of input.files) {
            formData.append('file', file, file.name)
          }

          let response = await fetch('upload2.php', {
            method: 'POST',
            body: formData
          });

          let result = await response.json();

          alert(result.upload);

      } catch (ex) {
        alert("Erro: " + ex);
      }

      
    }

</script>
</body>