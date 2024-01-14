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
list.forEach((item, indice)=>{
    item.addEventListener('click', function(){
        localStorage.setItem('itemActual', indice);
    });
})
list[localStorage.getItem('itemActual')].classList.add('hovered');

//TODOS LOS INPUTS EN MAYUSCULAS
$(document).ready( function () {
	setInterval(function(){
		$("input[type='text']").on("keypress", function () {
			$input=$(this);
			setTimeout(function () {
				$input.val($input.val().toUpperCase());
			},50);
		})
	})
})
