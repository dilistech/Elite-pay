const logoIcon = document.querySelector("#logo-icon");
const minMaxs = document.querySelectorAll("#min-max");
const minVal = document.querySelector("#min-val");
const maxVal = document.querySelector("#max-val");
const typeVal = document.querySelector("#type-val");

logoIcon.addEventListener('click', e => {
    let a = logoIcon.querySelector('a');
    a.classList.toggle("active");
    $(".main-menu").slideToggle(1500);    
  });

minMaxs.forEach(minMax => {
minMax.addEventListener('click', e => {
    if (e.target.getAttribute('type') === 'radio') {
      let parent = e.target.parentElement;
    let min = parent.querySelector('#min').value;
    let max = parent.querySelector('#max').value;
    let type = parent.querySelector('#type').value;
    minVal.value = min;
    maxVal.value = max;
    typeVal.value = type;
    }
    
   

    
    

  });
});
  
