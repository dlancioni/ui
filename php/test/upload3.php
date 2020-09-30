<body style="margin:0">

  <input type="button" value="Submit" onclick="submit()">
  <input type="file" name="img">

  <script>

    async function submit() {

      var input = document.querySelector('input[type="file"]')

      let formData = new FormData();

      formData.append("firstName", "John");
      formData.append('file', input.files[0])

      let response = await fetch('upload4.php', {
        method: 'POST',
        body: formData
      });

      let result = await response.json();
      alert(result);
    }

  </script>
</body>