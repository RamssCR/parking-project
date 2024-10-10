const btnActivate = document.querySelector('.activate_modal')
const btnDeactivate = document.querySelector('.quit')
const modal = document.querySelector('.modal')

btnActivate.addEventListener('click', () => modal.style.display = 'flex')
btnDeactivate.addEventListener('click', () => modal.style.display = 'none')