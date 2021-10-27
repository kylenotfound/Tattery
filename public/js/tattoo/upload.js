$(document).ready(function (e) {
  $('#image').change(function(){     
    let reader = new FileReader();
    reader.onload = (e) => { 
      $('#preview-image-before-upload').attr('src', e.target.result);
      $('img').width('350px').height('350px'); //rescale the image
    }
    reader.readAsDataURL(this.files[0]); 
  });
});

function lengthCheck(element) {
  var max = 150;
  var textArea = element.value.length;
  var charactersLeft = max - textArea;
  var count = document.getElementById('chars');
  count.innerHTML = "Characters left: " + charactersLeft;
}

lengthCheck(document.getElementById('newTwet'));