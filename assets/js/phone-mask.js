$(function(){
  $('#phone').on('input', function(){
    this.value = this.value.replace(/\D/g,'').slice(0,9);
  });
});