$(function() {

  $(".btn").on("click", function() {

    //hide all sections
    $(".content-section").hide();

    //show the section depending on which button was clicked

    $("#" + $(this).attr("data-section")).show();
    });

});

//Clicks posts button when page is loaded.
window.onload=function(){
  document.getElementById("posts").click();
};
