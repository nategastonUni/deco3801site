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
  const age = $("#ageGroup")
    .find(":selected")
    .text();

  if (email == "" || student == "" || age == "" || singer == "") {
    $("#message").html("<h5> All fields required</h5>");
  } else {
    request = $.ajax({
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
        age
    });
    request.done(function(response, textStatus, jqXHR) {
      if (textStatus == "success") {
        formSucess();
      }
      console.log("signup successful");
    });
    request.fail(function(jqXHR, textStatus, errorThrown) {
      formFailure();
      console.error("The following error occurred: " + textStatus, errorThrown);
    });
  }
}

function formSucess() {
  $("#message").html(
    '<h5><span class="label label-default">Thanks!</span></h5>'
  );
}

function formFailure() {
  $("#message").html('<h5><span class="label label-default">Error</span></h5>');
}
