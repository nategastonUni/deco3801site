$(document).ready(function() {
  $(window).scroll(function() {
    if ($(document).scrollTop() > 250) {
      $("#nav").addClass("shrink");
    } else {
      $("#nav").removeClass("shrink");
    }
  });
});

$(document).ready(function() {
  $("#register_form").submit(function(event) {
    //redirect form submission
    if (event.isDefaultPrevented()) {
      //handle invalid form
    } else {
      event.preventDefault();
      submitForm();
    }
  });
});

// $(document).ready(function() {
//   $("#form-submit").click(function(e) {
//     event.preventDefault();
//       submitForm();
//   });
// });

function submitForm() {
  $form = $(this);
  const email = $("#email").val();
  const student = $("input[name=studentRadio]:checked").val();
  const singer = $("input[name=singerRadio]:checked").val();
  const age = $("input[name=ageRadio]:checked").val();

  if (email == "" || student == "" || age == "" || singer == "") {
    $("#error-message").html("<h5> All fields required</h5>");
  } else {
    $.ajax({
      type: "POST",
      url: "php/register.php",
      data:
        "email=" +
        email +
        "&student=" +
        student +
        "&singer=" +
        singer +
        "&age=" +
        age,
      success: function(text) {
        if (text == "success") {
          formSucess();
        }
        console.log("signup successful");
      },
      error: function() {
        console.log("signup unsucessful");
      }
    });
  }
}

function formSucess() {
  $("#success-message").html("<h4> Registration submitted sucessfully </h4>");
}
