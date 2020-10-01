<body style="margin:0">

  <input type="button" value="Submit" onclick="submit()">
  <input type="file" name="file" multiple>

<script>

    async function submit() {

      try {

          var input = document.querySelector('input[type="file"]')
          let formData = new FormData();

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