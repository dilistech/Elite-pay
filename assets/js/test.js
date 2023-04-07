const deleteBtns = document.querySelectorAll('#delete');
let id = document.querySelector('#delete-id');

deleteBtns.forEach(deleteBtn => {
deleteBtn.addEventListener('click', e => {
let tr = e.target.parentNode.parentNode;
let tdId = tr.querySelector('#td-id');
id.value = tdId.value;

});
});

profit.addEventListener('keyup', e => {
balance.value = profit.value + amount.value;
});