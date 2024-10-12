const cards = document.querySelectorAll('.vehicle-card');
[...cards]

cards.forEach(card => {
    const pencil = card.querySelector('.edit')

    card.addEventListener('mouseover', () => pencil.style.opacity = '1')
    card.addEventListener('mouseout', () => pencil.style.opacity = '0')
})