$(document).ready(function () {
    $("#connButton").on("click", function (event) {
      event.preventDefault();

      const formData = new FormData($("#loginForm")[0]);
          $.ajax({
            url: "index.php?router=login",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
              if (response !== 1) {
                  alert(response);
                  console.log(response)
              } 
            },
            error: function () {
              alert("erreur!");
            },
          });
    });
  });