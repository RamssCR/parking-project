const tarifas = document.querySelectorAll('.tarifa');
[...tarifas]

const totals = document.querySelectorAll('.total');
[...totals]

const currencyFormat = (value) => new Intl.NumberFormat('es-CL').format(value)

tarifas.forEach(tarifa => tarifa.innerText = currencyFormat(tarifa.innerText))
totals.forEach(total => total.innerText = currencyFormat(total.innerText))