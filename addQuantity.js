const inputNumber = document.getElementById('quantityFood');
const minus = document.getElementById('minus');
const plus = document.getElementById('plus');

let count = 1;

plus.addEventListener('click', (e) => {
	e.preventDefault();
	count++;
	inputNumber.value = count;
});

minus.addEventListener('click', (e) => {
	e.preventDefault();
	if (count > 1) {
		count--;
		inputNumber.value = count;
	}
});
