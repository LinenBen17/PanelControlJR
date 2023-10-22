//MenuToggle
let toggle = document.querySelector('.toggle');
let navigation = document.querySelector('.navigation');
let main = document.querySelector('.main');

toggle.onclick = function(){
	navigation.classList.toggle('active');
	main.classList.toggle('active');
}
//add hovered class in selected list item
let list = document.querySelectorAll('.navigation li');
function activeLink() {
	list.forEach((item)=>{
		item.classList.remove('hovered');
	});
	this.classList.add('hovered');
}
list.forEach((item)=>{
	item.addEventListener('mouseover', activeLink)
})

//TODOS LOS INPUTS EN MAYUSCULAS
$(document).ready( function () {
	$("input[type='text']").on("keypress", function () {
		$input=$(this);
		setTimeout(function () {
			$input.val($input.val().toUpperCase());
		},50);
	})
})